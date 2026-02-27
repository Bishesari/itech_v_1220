<div>
    <flux:tooltip content="ویرایش رشته" position="bottom">
        <flux:button icon="pencil-square" size="xs" variant="primary" color="yellow" class="cursor-pointer"
                     x-on:click="$flux.modal('edit-province-{{ $field->id }}').show()">
        </flux:button>
    </flux:tooltip>

    <flux:modal name="edit-province-{{ $field->id }}" :show="$errors->isNotEmpty()" focusable class="md:w-96" flyout :dismissible="false">
        <div class="space-y-6">
            <flux:heading size="lg">{{__('ویرایش رشته ')}}
                <span class="font-bold text-yellow-500">{{ $field->title }}</span>
            </flux:heading>
            <flux:text class="mt-2">{{__('اطلاعات رشته را ویرایش کنید.')}}</flux:text>

            <form wire:submit.prevent="update" class="space-y-4 flex flex-col gap-3" autocomplete="off">
                <x-my.flt_lbl name="title" label="{{__('عنوان رشته:')}}" maxlength="40"
                              class="tracking-wider font-semibold" autofocus required/>
                <div class="flex">
                    <flux:spacer/>
                    <flux:button type="submit" variant="primary" color="yellow" size="sm"
                                 class="cursor-pointer">{{__('ویرایش')}}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
