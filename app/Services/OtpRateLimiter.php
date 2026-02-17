<?php

namespace App\Services;

use App\Models\OtpLog;

class OtpRateLimiter
{
    public function ipAllowed(): bool
    {
        return OtpLog::where('ip', request()->ip())
            ->where('created_at', '>=', now()->subHour())
            ->count() < 20;
    }

    public function nCodeAllowed(string $nCode): bool
    {
        return OtpLog::where('n_code', $nCode)
            ->where('created_at', '>=', now()->subDay())
            ->count() < 5;
    }

    public function contactAllowed(string $contact): bool
    {
        return OtpLog::where('contact_value', $contact)
            ->where('created_at', '>=', now()->subDay())
            ->count() < 5;
    }

    public function timeAllowed(string $nCode, string $contact): bool
    {
        return ! OtpLog::where(function ($q) use ($nCode, $contact) {
            $q->where('n_code', $nCode)
                ->orWhere('contact_value', $contact);
        })
            ->whereNull('verified_at')
            ->where('expires_at', '>=', now())
            ->exists();
    }

    public function canSend(string $ip, string $nCode, string $contact): bool
    {
        return $this->ipAllowed($ip)
            && $this->nCodeAllowed($nCode)
            && $this->contactAllowed($contact)
            && $this->timeAllowed($nCode, $contact);
    }
}
