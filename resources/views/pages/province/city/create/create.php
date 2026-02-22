<?php

use App\Models\City;
use App\Models\Province;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public $province_id;

    public Province $province;

    public bool $show_btn = true;

    public string $name = '';

    public string $slug = '';

    public function mount($province_id = null): void
    {
        $this->province_id = $province_id;
        $this->province = Province::find($province_id);
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'min:2', Rule::unique('cities', 'name')],
            'slug' => ['required', 'min:2', Rule::unique('cities', 'slug')],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();
        $validated['province_id'] = $this->province->id;

        $city = City::create($validated);
        $this->modal('new-city')->close();
        $this->dispatch('city-created', id: $city->id);

        Flux::toast(
            heading: 'ثبت شد.',
            text: 'شهر جدید با موفقیت ثبت شد.',
            variant: 'success',
            position: 'top right'
        );
    }

    public function reset_prop(): void
    {
        $this->reset('name');
        $this->reset('slug');
        $this->resetErrorBag();
    }
};
