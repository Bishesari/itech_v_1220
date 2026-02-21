<div>
    @if($show_btn)
        <flux:tooltip content="استان جدید" position="left">
            <flux:icon.plus-circle variant="micro" class="cursor-pointer size-5 text-blue-500 mr-4"
                                   x-on:click="$flux.modal('new-province').show()"/>
        </flux:tooltip>
    @endif

    <flux:modal name="new-province" :show="$errors->isNotEmpty()" focusable class="md:w-96" @close="reset_prop" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{__('درج استان جدید')}}</flux:heading>
                <flux:text class="mt-2">{{__('اطلاعات استان جدید را وارد کنید.')}}</flux:text>
            </div>

            <form wire:submit.prevent="save" class="space-y-4 flex flex-col gap-3" autocomplete="off">
                <x-my.flt_lbl name="name" label="{{__('نام استان فارسی:')}}" maxlength="40"
                              class="tracking-wider font-semibold" autofocus required/>
                <x-my.flt_lbl name="slug" label="{{__('نام استان لاتین:')}}" dir="ltr" maxlength="40"
                              class="tracking-wider font-semibold" required/>

                <div class="flex">
                    <flux:spacer/>
                    <flux:button type="submit" variant="primary" color="teal" size="sm"
                                 class="cursor-pointer">{{__('ثبت')}}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
