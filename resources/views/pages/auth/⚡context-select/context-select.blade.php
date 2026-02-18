<div class="flex flex-col gap-3">
    <!-- Header -->
    <div class="text-center space-y-2">
        <h1 class="text-xl text-gray-800 dark:text-gray-200 font-bold">
            {{ __('انتخاب نقش کاربری') }}
        </h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm">
            {{ __('برای ورود، یکی از نقش‌های زیر را انتخاب کنید') }}
        </p>
    </div>
    <!-- Roles -->
    @forelse($bru_s as $bru)
        <flux:callout
            wire:click="setBru({{ $bru->id }}, '{{ $bru->role->color ?? 'zinc' }}')"
            color="{{ $selectedBruId == $bru->id ? $bru->role->color ?? 'indigo' : 'zinc' }}"
            class="cursor-pointer"
        >
            <flux:callout.heading class="flex justify-between">
                <span>{{ $bru->role->name }}</span>

                @if($bru->institute)
                    <span>
                        {{ $bru->institute->short_name }}
                    </span>
                @endif

                @if($bru->branch)
                    <span>{{ $bru->branch->short_name }}</span>
                @endif
            </flux:callout.heading>
        </flux:callout>

    @empty
        <p class="text-center text-gray-500 dark:text-gray-400">
            {{ __('شما هیچ نقشی ندارید.') }}
        </p>
    @endforelse

    <!-- Error -->
    @error('selectedRoleId')
    <p class="text-red-500 text-sm text-center">{{ $message }}</p>
    @enderror

    @if($selectedBruId)
        <!-- CTA Button -->
        <flux:button
            wire:loading.remove
            wire:target="setBru"
            wire:click="dashboard"
            variant="primary"
            color="{{ $selectedColor ?? 'indigo' }}"
            class="cursor-pointer w-full py-2 text-sm font-medium relative"
            x-data="{ loading: false }"
            @click="loading = true"
        >
            <span x-show="!loading">{{ __('ادامه با نقش انتخابی') }}</span>
            <flux:icon.loading x-show="loading" class="size-5"/>
        </flux:button>

        <flux:button wire:loading wire:target="setBru"
                     class="w-full py-2 text-sm text-center font-medium">
            <flux:icon.loading class="inline-block"/>
        </flux:button>
    @endif
</div>
