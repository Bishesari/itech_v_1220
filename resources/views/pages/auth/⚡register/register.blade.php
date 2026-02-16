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

</div>
