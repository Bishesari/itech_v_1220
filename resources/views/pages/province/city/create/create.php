<?php

use App\Models\City;
use App\Models\Province;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public ?int $provinceId = null;

    public Province $province;

    public bool $showBtn = true;

    public string $name = '';

    public string $slug = '';

    public function mount(?int $provinceId = null): void
    {
        $this->provinceId = $provinceId;

        if ($provinceId) {
            $this->province = Province::findOrFail($provinceId);
        }
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
            text: 'شهر جدید با موفقیت ثبت شد.',
            heading: 'ثبت شد.',
            variant: 'success',
            position: 'top right'
        );
    }
    public function resetForm(): void
    {
        $this->reset(['name', 'slug']);
        $this->resetErrorBag();
    }
};
