<x-layouts::auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('ورود به حساب کاربری')" :description="__('نام کاربری و پسورد قبلا پیامک شده است.')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6"
            x-data="{ loading: false }" @submit="loading = true"
        >
            @csrf


            <!-- User Name -->
            <flux:input name="user_name"
                        :label="__('نام کاربری')"
                        :value="old('user_name')"
                        type="text"
                        required
                        autofocus
                        autocomplete="off"
                        class:input="tracking-widest text-center"
                        dir="ltr"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('کلمه عبور')"
                    type="password"
                    required
                    autocomplete="current-password"
                    viewable
                    class:input="tracking-widest text-center"
                    dir="ltr"
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('بازیابی کلمه عبور') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('بخاطرسپاری')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button
                    variant="primary" color="violet"
                    type="submit"
                    class="w-full cursor-pointer flex items-center justify-center gap-2"
                    x-bind:disabled="loading"
                >
                    <span>{{__('ورود')}}</span>
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
                <span>{{ __('حساب کاربری ندارید؟') }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __('ثبت نام کنید.') }}</flux:link>
            </div>
        @endif
    </div>
</x-layouts::auth>
