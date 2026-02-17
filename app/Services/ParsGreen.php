<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ParsGreen
{
    protected string $baseUrl;

    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('parsgreen.base_url'), '/').'/Apiv2/';
        $this->apiKey = config('parsgreen.api_key');
    }

    /**
     * ارسال OTP
     */
    public function sendOtp(
        string $mobile,
        string $code,
        int $templateId = 0,
        bool $addName = true
    ): object {
        return $this->request('Message/SendOtp', [
            'Mobile' => $mobile,
            'SmsCode' => $code,
            'TemplateId' => $templateId,
            'AddName' => $addName,
        ]);
    }

    /**
     * ارسال پیامک متنی
     */
    public function sendMessage(string|array $mobiles, string $text): object
    {
        $mobiles = is_array($mobiles) ? $mobiles : [$mobiles];

        return $this->request('Message/SendSms', [
            'Mobiles' => $mobiles,
            'SmsBody' => $text,
        ]);
    }

    /**
     * متد مرکزی ارسال درخواست
     */
    protected function request(string $endpoint, array $payload): object
    {
        try {
            $response = Http::withHeaders([
                'authorization' => 'BASIC APIKEY:'.$this->apiKey,
                'Content-Type' => 'application/json;charset=utf-8',
            ])->post($this->baseUrl.ltrim($endpoint, '/'), $payload);

            if ($response->failed()) {
                Log::error('ParsGreen SMS Error', [
                    'endpoint' => $endpoint,
                    'response' => $response->body(),
                ]);

                return (object) [
                    'R_Success' => false,
                    'R_Code' => $response->status(),
                    'R_Message' => 'HTTP Error',
                ];
            }

            return (object) $response->json();

        } catch (\Throwable $e) {
            Log::critical('ParsGreen Exception', [
                'message' => $e->getMessage(),
            ]);

            return (object) [
                'R_Success' => false,
                'R_Code' => -1,
                'R_Message' => $e->getMessage(),
            ];
        }
    }
}
