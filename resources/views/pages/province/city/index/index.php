<?php

use App\Models\City;
use App\Models\Province;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

new class extends Component
{
    public Province $province;

    use WithoutUrlPagination, WithPagination;

    public string $sortBy = 'name';

    public string $sortDirection = 'asc';

    public ?int $highlightedId = null;

    public int $perPage = 10;

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function cities()
    {
        return City::query()
            ->where('province_id', $this->province->id)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function toggleStatus(int $cityId): void
    {
        $city = City::findOrFail($cityId);

        $city->update([
            'is_active' => ! $city->is_active,
        ]);

        $this->dispatch('city-updated');

        Flux::toast(
            heading: 'به‌روزرسانی شد',
            text: 'وضعیت شهر با موفقیت تغییر کرد.',
            variant: 'warning',
            position: 'top right'
        );
    }

    #[On('city-created')]
    public function cityCreated($id = null): void
    {
        $this->reset('sortBy');
        $this->reset('sortDirection');

        $city = City::find($id);
        if (! $city) {
            return;
        }
        $beforeCount = City::where('name', '<', $city->name)->count();
        $page = intdiv($beforeCount, $this->perPage) + 1;
        $this->gotoPage($page);
        $this->highlightedId = $id;
    }

    #[On('city-updated')]
    public function cityUpdated($id = null): void
    {
        $this->highlightedId = $id;
    }

    #[On('city-deleted')]
    public function afterDelete(): void
    {
        $cities = $this->cities();
        if ($cities->isEmpty() && $cities->currentPage() > 1) {
            $this->previousPage();
        }
    }
};
