<flux:navlist.item icon="user-group" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate x-data="{ loading: false }"
                   @click="loading = true">
    <span>{{ __('داشبرد') }}</span>
    <flux:badge color="{{$role->color}}" size="sm" class="mr-2">{{__('سوپر ادمین')}}</flux:badge>
    <flux:icon.loading x-show="loading" class="inline absolute left-2 top-2 size-3.5 text-stone-700 dark:text-stone-300"/>
</flux:navlist.item>
<flux:navlist.group :heading="__('اطلاعات پایه')" class="grid" expandable :expanded="request()->routeIs(['role.index', 'province.index'])" >
    <flux:navlist.item icon="user-group" :href="route('role.index')" :current="request()->routeIs('role.index')" wire:navigate x-data="{ loading: false }"
                       @click="loading = true">
        <span>{{ __('نقشهای کاربری') }}</span>
        <flux:icon.loading x-show="loading" class="inline absolute left-2 size-3.5 text-stone-700 dark:text-stone-300"/>
    </flux:navlist.item>

    <flux:navlist.item icon="user-group" :href="route('province.index')" :current="request()->routeIs('province.index')" wire:navigate x-data="{ loading: false }"
                       @click="loading = true">
        <span>{{ __('استانها') }}</span>
        <flux:icon.loading x-show="loading" class="inline absolute left-2 size-3.5 text-stone-700 dark:text-stone-300"/>
    </flux:navlist.item>
</flux:navlist.group>
