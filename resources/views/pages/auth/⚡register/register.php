<?php

use App\Rules\NCode;
use App\Services\OtpService;
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
    public int $timer = 0; // front-end countdown
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

        $otpService = app(OtpService::class);

        $otp = $otpService->sendOtp(
            nCode: $this->n_code,
            contact: $this->contact_value,
            ip: request()->ip(),
        );

        $this->modal('otp_verify')->show();
        $this->timer = 120;
        $this->dispatch('set_timer');

        $this->dispatch('focus-otp');

        if (! $otp) {
            $this->addError('contact_value', 'ارسال OTP امکان‌پذیر نیست یا محدودیت دارید.');

            return;
        }


    }


};
