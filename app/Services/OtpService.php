<?php

namespace App\Services;

use App\Models\OtpLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OtpService
{
    protected ParsGreen $sms;

    protected OtpRateLimiter $rateLimiter;

    public function __construct(ParsGreen $sms, OtpRateLimiter $rateLimiter)
    {
        $this->sms = $sms;
        $this->rateLimiter = $rateLimiter;
    }

    public function sendOtp(
        string $nCode,
        string $contact,
        string $ip,
        int $expiryMinutes = 5,
        int $templateId = 0
    ): bool|string {
        // بررسی Rate Limit
        if (! $this->rateLimiter->canSend($ip, $nCode, $contact)) {
            return false;
        }

        $otp = random_int(100000, 999999);

        // ارسال SMS
        $response = $this->sms->sendOtp(
            mobile: $contact,
            code: (string) $otp,
            templateId: $templateId
        );

        if (! $response->R_Success) {
            Log::error('OTP send failed', [
                'n_code' => $nCode,
                'contact' => $contact,
                'response' => $response,
            ]);

            return false;
        }
        OtpLog::create([
            'ip' => $ip,
            'n_code' => $nCode,
            'contact_value' => $contact,
            'otp_hash' => $otp, // cast hashed خودش Hash::make می‌کند
            'expires_at' => now()->addMinutes($expiryMinutes),
        ]);

        return $otp; // برای تست یا debug
    }

    public function verifyOtp(string $contact, string $inputOtp): bool
    {
        $otpLog = OtpLog::where('contact_value', $contact)
            ->whereNull('verified_at')
            ->where('expires_at', '>=', now())
            ->latest('id')
            ->first();

        if (! $otpLog) {
            return false;
        }

        if (! Hash::check($inputOtp, $otpLog->otp_hash)) {
            $otpLog->increment('attempts');

            return false;
        }

        // موفق شدیم
        $otpLog->update([
            'verified_at' => now(),
        ]);

        return true;
    }
}
