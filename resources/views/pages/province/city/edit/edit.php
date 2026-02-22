<?php

use App\Models\City;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public City $city;

    public string $name = '';

    public string $slug = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'min:2', Rule::unique('cities', 'name')->ignore($this->city)],
            'slug' => ['required', 'min:2', Rule::unique('cities', 'slug')->ignore($this->city)],
        ];
    }

    public function mount(): void
    {
        $this->name = $this->city->name;
        $this->slug = $this->city->slug;
    }

    public function update_city(): void
    {
        $this->city->update($this->validate());
        $this->modal('edit-city-'.$this->city->id)->close();
        $this->dispatch('city-updated', id: $this->city->id);

        Flux::toast(
            heading: 'تغییرات اعمال شد.',
            text: 'شهر '.$this->name.' با موفقیت ویرایش شد.',
            variant: 'warning',
            position: 'top right'
        );
    }
};
