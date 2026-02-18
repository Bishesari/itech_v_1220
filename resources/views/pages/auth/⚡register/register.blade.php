<div>
    <x-auth-header :title="__('ایجاد حساب کاربری')" :description="__('اطلاعات خواسته شده را وارد نمایید.')" />

    <form wire:submit.prevent="check_inputs" class="flex flex-col gap-5 mt-5" autocomplete="off">
        <x-my.flt_lbl name="f_name_fa" label="{{__('نام:')}}" maxlength="30"
                      class="tracking-wider font-semibold" autofocus required/>

        <x-my.flt_lbl name="l_name_fa" label="{{__('نام خانوادگی:')}}" maxlength="40"
                      class="tracking-wider font-semibold" required/>

        <x-my.flt_lbl name="n_code" label="{{__('کدملی:')}}" dir="ltr" maxlength="10"
                      class="tracking-wider font-semibold" required/>
        <x-my.flt_lbl name="contact_value" label="{{__('شماره موبایل:')}}" dir="ltr" maxlength="11"
                      class="tracking-wider font-semibold" required/>
        <flux:button type="submit" variant="primary" color="teal" class="w-full cursor-pointer">
            {{ __('ادامه ثبت نام') }}
        </flux:button>
    </form>

    <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400 mt-4">
        <span>{{ __('حساب کاربری داشته اید؟') }}</span>
        <flux:button :href="route('login')" variant="ghost" icon:trailing="arrow-down-left" size="sm"
                     class="cursor-pointer">{{ __('وارد شوید.') }}
        </flux:button>
    </div>


    {{-------------------------- OTP VERIFY Modal --------------------------}}
    <flux:modal name="otp_verify" class="md:w-96" :dismissible="false" focusable>
        <form wire:submit.prevent="otp_verify" class="space-y-8">
            <div class="max-w-72 mx-auto space-y-2">
                <flux:heading size="lg" class="text-center">{{__('تایید کد پیامکی')}}</flux:heading>
                <flux:text class="text-center">{{__('کد پیامک شده را وارد کنید.')}}</flux:text>
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
    </flux:modal>

</div>
