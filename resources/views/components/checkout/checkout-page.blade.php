<?php

namespace App\Livewire\Checkout;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckoutPage extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $this->order = $order->load(['items', 'branch']);
    }

    public function pay()
    {
        if ($this->order->status !== 'awaiting_payment') {
            session()->flash('error', 'این سفارش قابل پرداخت نیست.');
            return;
        }

        $payment = Payment::create([
            'order_id' => $this->order->id,
            'user_id' => Auth::id(),
            'gateway' => 'test',
            'amount' => $this->order->payable_amount,
            'status' => 'paid',
            'authority' => 'TEST-' . now()->timestamp . '-' . $this->order->id,
            'ref_id' => 'REF-' . strtoupper(str()->random(8)),
            'paid_at' => now(),
            'payload' => [
                'mode' => 'test',
            ],
        ]);

        $this->order->update([
            'status' => 'paid',
            'paid_amount' => $this->order->payable_amount,
            'paid_at' => now(),
        ]);

        return redirect()->route('payment.result', $this->order);
    }


    public function render()
    {
        return view('livewire.checkout.checkout-page')
            ->layout('components.layouts.app');
    }
}

?>

<div class="max-w-3xl mx-auto space-y-6">
    <flux:heading size="xl">تسویه سفارش</flux:heading>

    @if (session('error'))
        <flux:callout variant="danger">
            {{ session('error') }}
        </flux:callout>
    @endif

    <flux:card>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-zinc-500">شماره سفارش</span>
                <span class="font-bold">#{{ $order->id }}</span>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-sm text-zinc-500">شعبه</span>
                <span>{{ $order->branch->title ?? '-' }}</span>
            </div>

            <hr>

            @foreach ($order->items as $item)
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium">{{ $item->title_snapshot }}</div>
                        <div class="text-sm text-zinc-500">تعداد: {{ $item->quantity }}</div>
                    </div>

                    <div class="font-bold">
                        {{ price_format($item->total_price) }}
                    </div>
                </div>
            @endforeach

            <hr>

            <div class="flex items-center justify-between text-lg font-bold">
                <span>مبلغ قابل پرداخت</span>
                <span>{{ price_format($order->payable_amount) }}</span>
            </div>

            <flux:button variant="primary" wire:click="pay">
                پرداخت آنلاین
            </flux:button>
        </div>
    </flux:card>
</div>

