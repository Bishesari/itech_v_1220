<?php

use App\Models\City;
use Livewire\Component;

new class extends Component
{
    public City $city;

    public string $name = '';

    public function mount(): void
    {
        $this->name = $this->city->name;
    }

    public function delete(): void
    {
        $cityName = $this->city->name;
        $cityId = $this->city->id;

        $this->city->delete();

        $this->modal('city-delete-'.$cityId)->close();
        $this->dispatch('city-deleted');

        Flux::toast(
            heading: 'حذف شد',
            text: "شهر {$cityName} با موفقیت حذف شد.",
            variant: 'danger',
            position: 'top right'
        );
    }
};
