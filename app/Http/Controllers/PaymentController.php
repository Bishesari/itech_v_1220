<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.index');
    }

    public function pay()
    {
        $amount = 200000; // ریال
        $resNum = 'ORD-'.time();

        // 1) ذخیره اولیه
        $payment = Payment::create([
            'amount' => $amount,
            'res_num' => $resNum,
            'status' => 'init',
        ]);

        // 2) گرفتن توکن از SEP
        $response = Http::asJson()->post('https://sep.shaparak.ir/onlinepg/onlinepg', [
            'action' => 'token',
            'TerminalId' => 31266886,
            'Amount' => $amount,
            'ResNum' => $resNum,
            'RedirectUrl' => route('payment.callback'),
        ]);
        $result = $response->json();
        if (! isset($result['token'])) {
            $payment->update(['status' => 'failed']);
            return 'خطا در دریافت توکن';
        }

        // 3) رفتن به صفحه پرداخت (با فرم auto submit)
        return view('payment.redirect', ['token' => $result['token']]);
    }

    public function callback(Request $request)
    {
        $payment = Payment::where('res_num', $request->ResNum)->firstOrFail();

        // اگر قبلا موفق شده، دوباره‌کاری نکن
        if ($payment->status === 'paid') {
            return 'این پرداخت قبلاً ثبت شده است.';
        }

        // اگر بانک خودش خطا داده
        if ($request->State !== 'OK') {
            $payment->update(['status' => 'failed']);

            return 'پرداخت ناموفق بود';
        }

        // 4) verify سمت سرور
        $verify = Http::asJson()->post(
            'https://sep.shaparak.ir/verifyTxnRandomSessionkey/ipg/VerifyTransaction',
            [
                'RefNum' => $request->RefNum,
                'TerminalNumber' => 31266886,
            ]
        );
        $result = $verify->json();

        if (! isset($result['ResultCode']) || $result['ResultCode'] != 0) {
            $payment->update(['status' => 'failed']);

            return 'verify ناموفق بود';
        }

        // 5) ثبت نهایی موفق
        $payment->update([
            'status' => 'paid',
            'ref_num' => $request->RefNum,
        ]);

        return 'پرداخت موفق ✅';
    }
}
