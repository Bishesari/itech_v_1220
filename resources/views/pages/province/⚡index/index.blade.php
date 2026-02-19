<div>
    <flux:heading size="lg" level="1">
        {{__('اطلاعات پایه')}}
    </flux:heading>

    <div class="inline-flex mt-2 mb-4">
        <flux:text>{{__('استان ها')}}</flux:text>
{{--        <livewire:province.create/>--}}
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
        <flux:table.rows>

            @foreach ($this->provinces as $province)
                <flux:table.row wire:key="province-row-{{ $province->id }}" class="transition duration-500 {{ $highlightProvinceId === $province->id ? 'bg-green-100 dark:bg-green-900/40' : '' }}">
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
{{--                            <flux:link href="{{ route('city.index', $province) }}" variant="subtle" wire:navigate x-data="{ loading: false }" @click="loading = true">--}}
{{--                                <span x-show="!loading" class="text-blue-500">{{ __('شهرها') }}</span>--}}
{{--                                <flux:icon.loading x-show="loading" class="size-5 text-blue-500 mr-3"/>--}}
{{--                            </flux:link>--}}

{{--                            <livewire:province.edit :province="$province" :key="'province-edit-'.$province->id"/>--}}

                            <flux:tooltip content="حذف استان" position="bottom">
                                <div class="inline-block">
                                    {{-- حالت عادی: نمایش آیکون سطل آشغال --}}
                                    {{-- وقتی روی confirmDelete با این ID خاص کلیک شد، این مخفی شود --}}
                                    <div wire:loading.remove wire:target="confirmDelete({{ $province->id }})">
                                        <flux:icon.trash
                                            variant="micro"
                                            class="cursor-pointer size-5 text-red-500 dark:text-red-400"
                                            wire:click="confirmDelete({{ $province->id }})"
                                        />
                                    </div>
                                    {{-- حالت لودینگ: نمایش آیکون چرخنده --}}
                                    {{-- فقط وقتی نمایش داده شود که confirmDelete با این ID خاص صدا زده شده --}}
                                    <div wire:loading wire:target="confirmDelete({{ $province->id }})">
                                        <flux:icon.loading class="size-5 text-red-500 dark:text-red-400" />
                                    </div>
                                </div>
                            </flux:tooltip>

                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>



    {{--    Confirm Delete Modal   --}}
    <flux:modal name="confirm" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{__('حذف استان ')}} <span
                        class="font-bold text-red-500 dark:text-red-400">{{$this->provinceToDelete?->name }}</span></flux:heading>
                <flux:text class="mt-2">{{__('با تایید اطلاعات مربوطه حذف خواهند شد.')}}</flux:text>
            </div>

            <div class="flex gap-2">
                {{-- دکمه تایید با لودینگ --}}
                <flux:button wire:click="deleteProvince" variant="primary" color="red" size="sm" class="flex-1 cursor-pointer">
                    <span wire:target="deleteProvince">{{__('تایید حذف')}}</span>
                </flux:button>

                {{-- دکمه انصراف --}}
                <flux:button x-on:click="$flux.modal('confirm').close()" variant="ghost" size="sm" class="flex-1 cursor-pointer">
                    {{__('انصراف')}}
                </flux:button>
            </div>
        </div>
    </flux:modal>


</div>
