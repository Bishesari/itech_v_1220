<?php

use App\Models\OtpLog;
use App\Rules\NCode;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new
#[Layout('layouts.auth')]
#[Title('فرم ثبت نام')]
class extends Component
{
    public string $f_name_fa = '';

    public string $l_name_fa = '';

    public string $n_code = '';

    public string $contact_value = '';

    protected function rules(): array
    {
        return [
            'f_name_fa' => ['required', 'min:2', 'max:30'],
            'l_name_fa' => ['required', 'min:2', 'max:40'],
            'n_code' => ['required', 'digits:10', new NCode, 'unique:profiles'],
            'contact_value' => ['required', 'starts_with:09', 'digits:11'],
        ];
    }

    public function check_inputs(): void
    {
        $this->validate();

        OtpLog::create(
            [
                'ip' => request()->ip(),
                'n_code' => $this->n_code,
                'contact_value' => $this->contact_value,
                'otp' => '123',
                'expires_at' => now()->addMinute(5),
            ]
        );

    }

    public function ip_allowed(): bool
    {
        $tooMany = OtpLog::where('ip', request()->ip())
            ->where('created_at', '>=', now()->subHour())
            ->limit(20)
            ->count() >= 20;

        return ! $tooMany;
    }

    public function n_code_allowed(): bool
    {
        $tooMany = OtpLog::where('n_code', $this->n_code)
            ->where('created_at', '>=', now()->subDay())
            ->limit(5)
            ->count() >= 5;

        return ! $tooMany;
    }

    public function mobile_allowed(): bool
    {
        $tooMany = OtpLog::where('mobile', $this->mobile)
            ->where('created_at', '>=', now()->subDay())
            ->limit(5)
            ->count() >= 5;

        return ! $tooMany;
    }

    public function time_allowed(): bool
    {
        $latestNCode = OtpLog::where('n_code', $this->n_code)
            ->latest('id')
            ->first();

        $activeNCode = $latestNCode && $latestNCode->expires_at >= now();

        $latestMobile = OtpLog::where('mobile', $this->mobile)
            ->latest('id')
            ->first();

        $activeMobile = $latestMobile && $latestMobile->expires_at >= now();

        return ! $activeNCode && ! $activeMobile;
    }

};
