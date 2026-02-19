<div>
    <flux:heading size="lg" level="1">
        {{__('اطلاعات پایه')}}
    </flux:heading>

    <div class="inline-flex mt-2 mb-4">
        <flux:text>{{__('نقشهای کاربری')}}</flux:text>
    </div>
    <flux:separator variant="subtle"/>

    <flux:table :paginate="$this->roles" class="inline">

        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'id'" :direction="$sortDirection"
                               wire:click="sort('id')">
                {{__('#')}}
            </flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                               wire:click="sort('name')">
                {{__('نقش')}}
            </flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'slug'" :direction="$sortDirection"
                               wire:click="sort('slug')">{{__('اسلاگ')}}</flux:table.column>

            <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                               wire:click="sort('created_at')">
                {{__('زمان ثبت')}}
            </flux:table.column>

            <flux:table.column sortable :sorted="$sortBy === 'updated_at'" :direction="$sortDirection"
                               wire:click="sort('updated_at')">
                {{__('زمان ویرایش')}}
            </flux:table.column>

        </flux:table.columns>



        <flux:table.rows>
            @foreach ($this->roles as $role)
                <flux:table.row class="transition duration-500 {{ $highlightRoleId === $role->id ? 'bg-green-100 dark:bg-green-900/40' : '' }}">
                    <flux:table.cell>{{ $role->id }}</flux:table.cell>
                    <flux:table.cell>{{ $role->name }}</flux:table.cell>
                    <flux:table.cell>{{ $role->slug }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap"><x-my.crup :date="$role->jalali_created_at" /></flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap"><x-my.crup :date="$role->jalali_updated_at" /></flux:table.cell>
                </flux:table.row>
            @endforeach

        </flux:table.rows>
    </flux:table>

</div>
