<div class="flex flex-col gap-4">
    <x-auth-session-status class="text-center" :status="session('status')"/>
    @if($step === 1)
        <x-auth-header :title="__('بازگردانی کلمه عبور')" :description="__('مرحله اول: دریافت کد ملی')"/>
        <form wire:submit.prevent="check_n_code" class="space-y-4 flex flex-col gap-4" autocomplete="off">
            <x-my.flt_lbl name="n_code" label="{{__('کدملی:')}}" dir="ltr" maxlength="10"
                          class="tracking-wider font-semibold" autofocus required/>
            <flux:button type="submit" variant="primary" color="teal" class="w-full cursor-pointer">
                {{ __('ادامه') }}
            </flux:button>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
            <span>{{ __('یا بازگردید به ') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('صفحه ورود') }}</flux:link>
        </div>
    @endif


    {{-------------------------- OTP VERIFY --------------------------}}
    @if($step === 2)
        <x-auth-header color="text-yellow-600" :title="__('بازگردانی کلمه عبور')" :description="__('مرحله دوم: انتخاب شماره موبایل و ارسال otp')"/>
        <flux:text class="text-center">{{__('نام کاربری و کلمه عبور جدید پیامک خواهد شد.')}}</flux:text>

        <form wire:submit.prevent="otp_verify" class="space-y-8">
            <!-- National Code and Mobile -->
            <div class="grid grid-cols-2 gap-4">
                <flux:text class="mt-2 text-center">{{__('کدملی: ')}}{{$n_code}}</flux:text>
                @if(count($mobiles) > 1)
                    <flux:select wire:model="contact_value" variant="listbox" placeholder="انتخاب موبایل">
                        @foreach($mobiles as $mobile)
                            <flux:select.option value="{{$mobile}}"
                                                style="text-align: center">{{mask_mobile($mobile)}}</flux:select.option>
                        @endforeach
                    </flux:select>
                @else
                    <flux:text class="mt-2 text-center">{{__('موبایل: ')}}{{mask_mobile($contact_value)}}</flux:text>
                @endif
            </div>

            <flux:otp wire:model="u_otp" id="otp-input-wrapper" submit="auto" :error:icon="false" error:class="text-center" class="mx-auto" dir="ltr">
                <flux:otp.input autofocus/> <flux:otp.input /> <flux:otp.input />
                <flux:otp.separator />
                <flux:otp.input /> <flux:otp.input /><flux:otp.input />
            </flux:otp>

            @if($otp_log_check_err)
                <flux:text class="text-center" color="rose">{{$otp_log_check_err}}</flux:text>
            @endif

            <div class="space-y-4">
                @if ($timer > 0)
                    <flux:button wire:click="otp_send" class="w-full" disabled>
                        <span id="timer">{{$timer}}</span>{{ __(' ثانیه تا ارسال مجدد') }}
                    </flux:button>
                @else
                    <flux:button wire:click="otp_send" variant="primary" color="teal"
                                 class="w-full cursor-pointer">{{ __('ارسال پیامک') }}</flux:button>
                @endif
            </div>
        </form>
    @endif
</div>
