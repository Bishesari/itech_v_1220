<?php

namespace App\Livewire\Booklets;

use App\Models\BranchStandardBooklet;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowBookletPage extends Component
{
    public BranchStandardBooklet $booklet;

    public ?int $currentPrice = null;

    public bool $alreadyPurchased = false;

    public function mount(BranchStandardBooklet $booklet): void
    {
        $this->booklet = $booklet->load(['branch', 'standard', 'prices']);
        $this->currentPrice = optional($this->booklet->currentPrice())->price;

        $this->alreadyPurchased = Order::query()
            ->where('user_id', Auth::id())
            ->where('status', 'paid')
            ->whereHas('items', function ($query) {
                $query->where('item_type', 'booklet')
                    ->where('item_id', $this->booklet->id);
            })
            ->exists();
    }

    public function buy()
    {
        if (! $this->booklet->is_active) {
            session()->flash('error', 'این جزوه در حال حاضر قابل خرید نیست.');
            return;
        }

        $priceModel = $this->booklet->currentPrice();

        if (! $priceModel) {
            session()->flash('error', 'قیمت فعالی برای این جزوه تعریف نشده است.');
            return;
        }

        if ($this->alreadyPurchased) {
            session()->flash('error', 'شما قبلاً این جزوه را خریداری کرده‌اید.');
            return;
        }

        $order = DB::transaction(function () use ($priceModel) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'branch_id' => $this->booklet->branch_id,
                'status' => 'awaiting_payment',
                'subtotal_amount' => $priceModel->price,
                'discount_amount' => 0,
                'payable_amount' => $priceModel->price,
                'paid_amount' => 0,
                'currency' => 'IRT',
            ]);

            $order->items()->create([
                'item_type' => 'booklet',
                'item_id' => $this->booklet->id,
                'title_snapshot' => $this->booklet->title,
                'quantity' => 1,
                'unit_price' => $priceModel->price,
                'total_price' => $priceModel->price,
            ]);

            return $order;
        });

        return redirect()->route('checkout.show', $order);
    }

    public function render()
    {
        return view('livewire.booklets.show-booklet-page')
            ->layout('components.layouts.app');
    }
}

?>

<div class="max-w-3xl mx-auto space-y-6">
    <flux:heading size="xl">{{ $booklet->title }}</flux:heading>

    <div class="grid md:grid-cols-2 gap-4">
        <flux:card>
            <div class="space-y-3">
                <div>
                    <div class="text-sm text-zinc-500">شعبه</div>
                    <div class="font-medium">{{ $booklet->branch->title ?? '-' }}</div>
                </div>

                <div>
                    <div class="text-sm text-zinc-500">استاندارد</div>
                    <div class="font-medium">{{ $booklet->standard->title ?? $booklet->standard->name_fa ?? '-' }}</div>
                </div>

                <div>
                    <div class="text-sm text-zinc-500">وضعیت</div>
                    <div class="font-medium">
                        {{ $booklet->is_active ? 'فعال' : 'غیرفعال' }}
                    </div>
                </div>
            </div>
        </flux:card>

        <flux:card>
            <div class="space-y-3">
                <div class="text-sm text-zinc-500">قیمت فعلی</div>
                <div class="text-2xl font-bold">
                    {{ $currentPrice ? price_format($currentPrice) : 'نامشخص' }}
                </div>

                @if (session('error'))
                    <flux:callout variant="danger">
                        {{ session('error') }}
                    </flux:callout>
                @endif

                @if ($alreadyPurchased)
                    <flux:button variant="filled" disabled>
                        قبلاً خریداری شده
                    </flux:button>
                @else
                    <flux:button variant="primary" wire:click="buy">
                        خرید جزوه
                    </flux:button>
                @endif
            </div>
        </flux:card>
    </div>

    <flux:card>
        <flux:subheading>توضیحات</flux:subheading>
        <div class="mt-3 text-sm leading-7 text-zinc-700">
            {{ $booklet->description ?: 'توضیحی ثبت نشده است.' }}
        </div>
    </flux:card>
</div>
