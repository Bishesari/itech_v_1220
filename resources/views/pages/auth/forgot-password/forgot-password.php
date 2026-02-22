<?php

use App\Jobs\OtpSend;
use App\Jobs\SmsPass;
use App\Models\OtpLog;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new
#[Layout('layouts.auth')]
#[Title('فراموشی کلمه عبور')]
class extends Component
{
    // === Configuration ===
    private const OTP_RESEND_DELAY = 120;         // seconds until next allowed send

    private const OTP_TTL = 300;                  // seconds OTP is valid (e.g., 5 minutes)

    private const MAX_PER_N_CODE_PER_DAY = 5;

    private const MAX_UNIQUE_N_CODES_PER_IP_PER_DAY = 3;

    private const OTP_TABLE = 'otp_logs';

    // === Public properties (bound to UI) ===
    public int $step = 1;

    public string $n_code = '';

    public string $contact_value = '';

    public array $mobiles = [];

    public string $u_otp = '';

    public int $timer = 0; // front-end countdown

    public string $otp_log_check_err = '';

    protected function rules(): array
    {
        return [
            'n_code' => ['required'],
            'contact_value' => ['required'],
        ];
    }

    // -------------------------
    // Step 1:
    // -------------------------

    public function check_n_code(): void
    {
        $this->validateOnly('n_code');
        $profile = Profile::where('n_code', $this->n_code)->first();
        if (! $profile) {
            $this->addError('n_code', 'کد ملی یافت نشد.');

            return;
        }
        $user = $profile->user;
        $this->mobiles = $user->contacts->pluck('contact_value')->toArray();
        if (empty($this->mobiles)) {
            $this->addError('n_code', 'هیچ شماره موبایلی برای این کد ملی ثبت نشده است.');

            return;
        }
        if (count($this->mobiles) == 1) {
            $this->contact_value = $this->mobiles[0];
            $this->otp_send();
        }
        $this->log_check();
        $this->u_otp = '';
        $this->step = 2;
    }

    // -------------------------
    // Step 2: send otp (rate-limited)
    // -------------------------
    public function otp_send(): void
    {
        // Validate inputs first (prevents abuse of endpoint)
        $this->validate();

        // If rate limits / timers fail, show errors
        if (! $this->log_check(showError: true)) {
            return;
        }

        $this->u_otp = '';

        // Generate numeric OTP
        $otp = NumericOTP();

        // Create log record
        OtpLog::create([
            'ip' => request()->ip(),
            'n_code' => $this->n_code,
            'contact_value' => $this->contact_value,
            'otp' => $otp,
            'otp_next_try_time' => time() + self::OTP_RESEND_DELAY,
            'otp_expires_at' => now()->addSeconds(self::OTP_TTL),
        ]);

        // Dispatch SMS job with plain OTP (job can be retried safely)
        OtpSend::dispatch($this->contact_value, $otp);

        // start client timer
        $this->timer = self::OTP_RESEND_DELAY;
        $this->dispatch('set_timer');

        $this->dispatch('focus-otp');
    }

    // -------------------------
    // Rate-limit + timer inspection
    // -------------------------
    /**
     * log_check
     *
     * @param  bool  $showError  whether to populate $otp_log_check_err (true for otp_send; false for check_inputs)
     * @return bool true => OK to send, false => blocked
     */
    public function log_check(bool $showError = true): bool
    {
        $this->otp_log_check_err = '';
        $this->timer = 0;

        $ip = request()->ip();
        $n_code = $this->n_code;
        $oneDayAgo = now()->subDay();

        // last record for this n_code in last 24 hours
        $latest = DB::table(self::OTP_TABLE)
            ->where('n_code', $n_code)
            ->where('created_at', '>=', $oneDayAgo)
            ->latest('id')
            ->first();

        // total sends for this n_code in last 24h
        $countForNCode = DB::table(self::OTP_TABLE)
            ->where('n_code', $n_code)
            ->where('created_at', '>=', $oneDayAgo)
            ->count();

        // distinct n_codes for this ip in last 24h
        $uniqueNcodesForIp = DB::table(self::OTP_TABLE)
            ->selectRaw('COUNT(DISTINCT n_code) as cnt')
            ->where('ip', $ip)
            ->where('created_at', '>=', $oneDayAgo)
            ->value('cnt') ?? 0;

        // If we have a last record, check resend window and per-n-code limit
        if ($latest) {
            // If resend wait still active => block and set timer
            if (! empty($latest->otp_next_try_time) && $latest->otp_next_try_time > time()) {
                $this->timer = $latest->otp_next_try_time - time();
                $this->dispatch('set_timer');

                if ($showError) {
                    $this->otp_log_check_err = 'تا زمان امکان ارسال مجدد لطفاً منتظر بمانید.';
                }

                return false;
            }

            // Per-n-code daily limit
            if ($countForNCode >= self::MAX_PER_N_CODE_PER_DAY) {
                if ($showError) {
                    $this->otp_log_check_err = 'در ۲۴ ساعت گذشته حداکثر تعداد ارسال برای این کد ملی انجام شده است.';
                }

                return false;
            }

            // allowed
            return true;
        }

        // if no latest record (first send for this n_code in 24h), check ip uniqueness limit
        if ((int) $uniqueNcodesForIp >= self::MAX_UNIQUE_N_CODES_PER_IP_PER_DAY) {
            if ($showError) {
                $this->otp_log_check_err = 'این IP در ۲۴ ساعت گذشته بیش از حد مجاز ثبت‌نام انجام داده است.';
            }

            return false;
        }

        return true;
    }

    // -------------------------
    // Verify OTP and create user
    // -------------------------
    public function otp_verify(): void
    {
        $this->otp_log_check_err = '';

        // Find latest OTP record for this n_code + mobile
        $latest = DB::table(self::OTP_TABLE)
            ->where('n_code', $this->n_code)
            ->where('contact_value', $this->contact_value)
            ->latest('id')
            ->first();

        if (! $latest) {
            $this->otp_log_check_err = 'هنوز کدی ارسال نشده است.';

            return;
        }
        // بازسازی تایمر برای جلوگیری از Expire اشتباه
        if ($latest->otp_next_try_time > time()) {
            $this->timer = $latest->otp_next_try_time - time();
            $this->dispatch('set_timer');
        }

        // Check OTP expiry (use otp_expires_at field)
        if (empty($latest->otp_expires_at) || now()->greaterThan($latest->otp_expires_at)) {
            $this->otp_log_check_err = 'کد پیامکی منقضی شده است.';

            return;
        }
        if (! Hash::check($this->u_otp, $latest->otp)) {
            $this->otp_log_check_err = 'کد پیامکی اشتباه است.';

            return;
        }

        // success: reset user password
        DB::transaction(function () {

            $tempPass = simple_pass(6);

            $user = Profile::where('n_code', $this->n_code)->first()->user;
            $user->password = $tempPass;
            $user->save();

            // remove OTP logs for this n_code + mobile
            DB::table(self::OTP_TABLE)
                ->where('n_code', $this->n_code)
                ->where('contact_value', $this->contact_value)
                ->delete();

            // send the temporary password via SmsPass job
            SmsPass::dispatch($this->contact_value, $user->user_name, $tempPass);
        });
        // ✅ ذخیره پیام در session قبل از redirect
        session()->flash('status', 'رمز عبور جدید به شماره موبایل شما پیامک شد.');

        // stop client timer and redirect or reload
        $this->dispatch('stop_timer');
        $this->redirect(route('login', absolute: false));
    }

    public function reset_all(): void
    {
        $this->reset([
            'n_code',
            'contact_value',
            'mobiles',
            'u_otp',
            'step',
            'timer',
            'otp_log_check_err',
        ]);

        $this->resetErrorBag();
        $this->step = 1; // بازگشت به مرحله اول
        $this->dispatch('stop_timer');
    }
};
