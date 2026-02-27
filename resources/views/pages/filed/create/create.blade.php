<div>
    @if($showBtn)
        <flux:tooltip content="رشته جدید" position="left">
            <flux:icon.plus-circle variant="micro" class="cursor-pointer size-5 text-blue-500 mr-4"
                                   x-on:click="$flux.modal('new-field').show()"/>
        </flux:tooltip>
    @endif

    <flux:modal name="new-field" :show="$errors->isNotEmpty()" focusable class="md:w-96" @close="resetForm" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{__('درج رشته جدید')}}</flux:heading>
                <flux:text class="mt-2">{{__('اطلاعات رشته آموزشی جدید را وارد کنید.')}}</flux:text>
            </div>

            <form wire:submit.prevent="save" class="space-y-4 flex flex-col gap-3" autocomplete="off">
                <x-my.flt_lbl name="title" label="{{__('عنوان رشته:')}}" maxlength="40"
                              class="tracking-wider font-semibold" autofocus required/>
                <div class="flex">
                    <flux:spacer/>
                    <flux:button type="submit" variant="primary" color="teal" size="sm"
                                 class="cursor-pointer">{{__('ثبت')}}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
