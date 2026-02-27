<div>
    <flux:tooltip content="ویرایش استان" position="bottom">
        <flux:button icon="pencil-square" size="xs" variant="primary" color="yellow" class="cursor-pointer"
                     x-on:click="$flux.modal('edit-province-{{ $province->id }}').show()">
        </flux:button>
    </flux:tooltip>

    <flux:modal name="edit-province-{{ $province->id }}" :show="$errors->isNotEmpty()" focusable class="md:w-96" flyout :dismissible="false">
        <div class="space-y-6">
            <flux:heading size="lg">{{__('ویرایش استان ')}}
                <span class="font-bold text-yellow-500">{{ $province->name }}</span>
            </flux:heading>
            <flux:text class="mt-2">{{__('اطلاعات استان را جهت ویرایش وارد کنید.')}}</flux:text>

            <form wire:submit.prevent="update" class="space-y-4 flex flex-col gap-3" autocomplete="off">
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
