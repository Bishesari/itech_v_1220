<flux:navlist.item icon="user-group" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate x-data="{ loading: false }"
                   @click="loading = true">
    <span>{{ __('داشبرد') }}</span>
    <flux:badge color="{{$role->color}}" size="sm" class="mr-2">{{__('سوپر ادمین')}}</flux:badge>
    <flux:icon.loading x-show="loading" class="inline absolute left-2 top-2 size-3.5 text-stone-700 dark:text-stone-300"/>
</flux:navlist.item>
