<?php

namespace App\Livewire\Payments;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaymentResultPage extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $this->order = $order->load(['payments' => fn ($q) => $q->latest()]);
    }

    public function getLatestPaymentProperty()
    {
        return $this->order->payments->first();
    }

    public function render()
    {
        return view('livewire.payments.payment-result-page')
            ->layout('components.layouts.app');
    }
}

?>

<div class="max-w-2xl mx-auto space-y-6">
    <flux:heading size="xl">نتیجه پرداخت</flux:heading>

    @if ($order->status === 'paid')
        <flux:callout variant="success">
            پرداخت با موفقیت انجام شد.
        </flux:callout>
    @else
        <flux:callout variant="danger">
            پرداخت ناموفق بود.
        </flux:callout>
    @endif

    <flux:card>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-zinc-500">شماره سفارش</span>
                <span class="font-bold">#{{ $order->id }}</span>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-sm text-zinc-500">وضعیت سفارش</span>
                <span>{{ $order->status }}</span>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-sm text-zinc-500">مبلغ</span>
                <span>{{ price_format($order->payable_amount) }}</span>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-sm text-zinc-500">کد رهگیری</span>
                <span>{{ $this->latestPayment?->ref_id ?? '-' }}</span>
            </div>

            <div class="pt-4 flex gap-3">
                <flux:button :href="route('orders.show', $order)" wire:navigate>
                    مشاهده سفارش
                </flux:button>

                <flux:button variant="ghost" :href="route('orders.my')" wire:navigate>
                    لیست سفارش‌های من
                </flux:button>
            </div>
        </div>
    </flux:card>
</div>
