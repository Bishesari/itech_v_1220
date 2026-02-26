<div class="text-center">
    <flux:tooltip content="حذف شهر" position="bottom">
        <flux:button icon="trash" size="xs" variant="primary" color="red" class="cursor-pointer"
                     x-on:click="$flux.modal('delete-city-{{ $city->id }}').show()">
        </flux:button>
    </flux:tooltip>


    <flux:modal name="delete-city-{{ $city->id }}" :show="$errors->isNotEmpty()" focusable class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{__('حذف شهر ')}} <span
                        class="font-bold text-red-500 dark:text-red-400">{{ $city->name }}</span></flux:heading>
                <flux:text class="mt-2">{{__('با تایید حذف اطلاعات مربوطه حذف خواهند شد.')}}</flux:text>
            </div>

            <form wire:submit.prevent="delete" class="space-y-4 flex flex-col gap-3" autocomplete="off">
                <div class="flex">
                    <flux:spacer/>
                    <flux:button type="submit" variant="primary" color="red" size="sm"
                                 class="cursor-pointer">{{__('تایید حذف')}}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
