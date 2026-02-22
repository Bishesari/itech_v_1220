<div>
    <flux:heading size="lg" level="1">
        {{__('اطلاعات پایه')}}
    </flux:heading>

    <div class="inline-flex mt-2 mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{route('province.index')}}" wire:navigate x-data="{ loading: false }"
                                   @click="loading = true">
                <span x-show="!loading" x-cloak class="text-blue-500">{{__('استان')}}</span>
                <flux:icon.loading x-show="loading" x-cloak class="size-5 animate-spin text-blue-500 mr-3"/>
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{$province->name}}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <livewire:pages::province.city.create :province_id="$province->id"/>
    </div>

    <flux:separator variant="subtle"/>

    <flux:table :paginate="$this->cities" class="inline">
        <flux:table.columns>
            <flux:table.column>{{__('#')}}</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                               wire:click="sort('name')">
                {{__('شهر')}}
            </flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'slug'" :direction="$sortDirection"
                               wire:click="sort('slug')">{{__('اسلاگ')}}</flux:table.column>
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
        <flux:table.rows>

            @if($highlightedId)
                <div x-data x-init="setTimeout(() => $wire.set('highlightedId', null), 2000)"></div>
            @endif

            @foreach ($this->cities as $city)
                @php
                    $class='';
                    if($highlightedId === $city->id){
                        $class='bg-green-100 dark:bg-green-900/40';
                    }
                @endphp
                <flux:table.row class=" {{$class}} dark:hover:bg-stone-900/80 transition duration-300 hover:bg-zinc-100" :key="$city->id">

                    <flux:table.cell>{{ $city->id }}</flux:table.cell>
                    <flux:table.cell>{{ $city->name }}</flux:table.cell>
                    <flux:table.cell>{{ $city->slug }}</flux:table.cell>


                    <flux:table.cell>
                        <div class="inline-flex items-center gap-2">
                            <flux:badge size="sm" color="{{ $city->is_active ? 'green' : 'red' }}">
                                {{ $city->is_active ? 'فعال' : 'غیرفعال' }}
                            </flux:badge>

                            @php
                                $checked = $city->is_active ? 'checked' : null;
                            @endphp
                            <flux:switch :$checked
                                         wire:key="province-switch-{{ $city->id }}-{{ $city->is_active }}"
                                         wire:click="toggleStatus({{ $city->id }})"
                                         wire:loading.attr="disabled"
                            />

                        </div>
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap"><x-my.crup :date="$city->jalali_created_at" /></flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap"><x-my.crup :date="$city->jalali_updated_at" /></flux:table.cell>


                    <flux:table.cell>
                        <div class="inline-flex items-center gap-2">
                            <livewire:pages::province.city.edit :$city :key="'city-edit-'.$city->id"/>
{{--                            <livewire:province.city.delete :$city :key="'city-delete-'.$city->id"/>--}}
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>


</div>
