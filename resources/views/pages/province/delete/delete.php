<?php

use App\Models\Province;
use Livewire\Component;

new class extends Component
{
    public Province $province;

    public string $name = '';

    public function mount(): void
    {
        $this->name = $this->province->name;
    }

    public function delete(): void
    {
        $provinceName = $this->province->name;
        $provinceId = $this->province->id;

        $this->province->delete();

        $this->modal('province-delete-'.$provinceId)->close();
        $this->dispatch('province-deleted');

        Flux::toast(
            text: "استان {$provinceName} با موفقیت حذف شد.",
            heading: 'حذف شد',
            variant: 'danger',
            position: 'top right'
        );
    }
};
