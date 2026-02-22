
<div>
    <flux:tooltip content="ویرایش شهر" position="bottom">
        <flux:icon.pencil-square variant="micro" class="cursor-pointer size-5 text-yellow-500"
                                 x-on:click="$flux.modal('edit-city-{{ $city->id }}').show()"/>
    </flux:tooltip>

    <flux:modal name="edit-city-{{ $city->id }}" :show="$errors->isNotEmpty()" focusable class="md:w-96" flyout
                :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{__('ویرایش شهر ')}} <span  class="font-bold text-yellow-500">{{ $city->name_fa }}</span></flux:heading>
                <flux:text class="mt-2">{{__('اطلاعات شهر را جهت ویرایش را وارد کنید.')}}</flux:text>
            </div>

            <form wire:submit.prevent="update_city" class="space-y-4 flex flex-col gap-3" autocomplete="off">
                <x-my.flt_lbl name="name" label="{{__('نام شهر فارسی:')}}" maxlength="40"
                              class="tracking-wider font-semibold" autofocus required/>
                <x-my.flt_lbl name="slug" label="{{__('نام شهر لاتین:')}}" dir="ltr" maxlength="40"
                              class="tracking-wider font-semibold" required/>

                <div class="flex">
                    <flux:spacer/>
                    <flux:button type="submit" variant="primary" color="yellow" size="sm"
                                 class="cursor-pointer">{{__('ویرایش')}}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
