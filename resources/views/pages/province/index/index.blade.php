<div>
    <flux:heading size="lg" level="1">
        {{__('اطلاعات پایه')}}
    </flux:heading>

    <div class="inline-flex mt-2 mb-4">
        <flux:text>{{__('استان ها')}}</flux:text>
        <livewire:pages::province.create />
    </div>

    <flux:separator variant="subtle"/>

    <flux:table :paginate="$this->provinces" class="inline">
        <flux:table.columns>
            <flux:table.column>{{__('#')}}</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                               wire:click="sort('name')">
                {{__('استان')}}
            </flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'slug'" :direction="$sortDirection"
                               wire:click="sort('slug')">{{__('اسلاگ')}}</flux:table.column>
            <flux:table.column>{{__('تعداد شهرها')}}</flux:table.column>

            <flux:table.column>{{__('فعال')}}</flux:table.column>


            <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                               wire:click="sort('created_at')">
                {{__('زمان ثبت')}}
            </flux:table.column>

            <flux:table.column align="center" sortable :sorted="$sortBy === 'updated_at'" :direction="$sortDirection"
                               wire:click="sort('updated_at')">
                {{__('زمان ویرایش')}}
            </flux:table.column>


            <flux:table.column>{{ __('عملیات') }}</flux:table.column>
        </flux:table.columns>

        @if($highlightedId)
            <div x-data x-init="setTimeout(() => $wire.set('highlightedId', null), 2000)"></div>
        @endif
        <flux:table.rows>


            @foreach ($this->provinces as $province)
                    @php
                        $class='';
                        if($highlightedId === $province->id){
                            $class='bg-green-100 dark:bg-green-900/40';
                        }
                    @endphp

                    <flux:table.row class=" {{$class}} dark:hover:bg-stone-900/80 transition duration-300 hover:bg-zinc-100" :key="$province->id">
                        <flux:table.cell>{{ $province->id }}</flux:table.cell>
                        <flux:table.cell>{{ $province->name }}</flux:table.cell>
                        <flux:table.cell>{{ $province->slug }}</flux:table.cell>
                        <flux:table.cell class="text-center">
                            <flux:badge color="green" size="sm"
                                        inset="top bottom">{{ $province->cities_count }}</flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>

                            <div class="inline-flex items-center gap-2">

                                <flux:badge size="sm" color="{{ $province->is_active ? 'green' : 'red' }}">
                                    {{ $province->is_active ? 'فعال' : 'غیرفعال' }}
                                </flux:badge>

                                @php
                                    $checked = $province->is_active ? 'checked' : null;
                                    @endphp
                                <flux:switch :$checked
                                             wire:key="province-switch-{{ $province->id }}-{{ $province->is_active }}"
                                             wire:click="toggleStatus({{ $province->id }})"
                                             wire:loading.attr="disabled"
                                />

                            </div>
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap"><x-my.crup :date="$province->jalali_created_at" /></flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap"><x-my.crup :date="$province->jalali_updated_at" /></flux:table.cell>


                        <flux:table.cell>

                            <div class="inline-flex items-center gap-2">
                                <flux:button size="sm" variant="subtle" href="{{ route('city.index', $province) }}" wire:navigate x-data="{ loading: false }" @click="loading = true">
                                    <span x-show="!loading" class="text-blue-500">{{ __('شهرها') }}</span>
                                    <flux:icon.loading x-show="loading" class="size-5 text-blue-500"/>
                                </flux:button>

                                <livewire:pages::province.edit :$province :key="'province-edit-'.$province->id"/>
                                <livewire:pages::province.delete :$province :key="'province-delete-'.$province->id"/>

                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
        </flux:table.rows>
    </flux:table>
</div>
