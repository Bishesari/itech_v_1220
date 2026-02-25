<?php

use App\Models\Province;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

new
#[Title('استانها')]
class extends Component
{
    use WithPagination;

    public string $sortBy = 'name';

    public string $sortDirection = 'asc';

    public ?int $deletingProvinceId = null;

    public ?int $highlightedId = null;

    public int $perPage = 10;

    public function sort($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

            return;
        }
        $this->sortBy = $column;
        $this->sortDirection = 'asc';

    }

    #[Computed]
    public function provinces(): LengthAwarePaginator
    {
        return Province::query()
            ->orderBy($this->sortBy, $this->sortDirection)
            ->withCount('cities')
            ->paginate($this->perPage);
    }

    #[Computed]
    public function provinceToDelete()
    {
        if (! $this->deletingProvinceId) {
            return null;
        }
        return Province::find($this->deletingProvinceId);
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingProvinceId = $id;
        $this->modal('confirm')->show();
    }

    public function deleteProvince(): void
    {
        $province = $this->provinceToDelete();

        if (! $province) {
            $this->modal('confirm')->close();
            $this->deletingProvinceId = null;
            return;
        }

        $province->delete();

        $this->modal('confirm')->close();
        $this->deletingProvinceId = null;

        $this->dispatch('province-deleted');

        Flux::toast(
            heading: 'حذف شد',
            text: 'استان با موفقیت حذف شد.',
            variant: 'danger',
            position: 'top right'
        );
    }

    public function toggleStatus(int $provinceId): void
    {
        $province = Province::findOrFail($provinceId);

        $province->update([
            'is_active' => ! $province->is_active,
        ]);

        Flux::toast(
            heading: 'به‌روزرسانی شد',
            text: 'وضعیت استان با موفقیت تغییر کرد.',
            variant: 'warning',
            position: 'top right'
        );
    }

    #[On('province-created')]
    public function provinceCreated(?int $id = null): void
    {
        $this->reset(['sortBy', 'sortDirection']);

        if (! $id) {
            return;
        }

        $province = Province::find($id);
        if (! $province) {
            return;
        }

        $beforeCount = Province::where('name', '<', $province->name)->count();
        $page = intdiv($beforeCount, $this->perPage) + 1;

        $this->gotoPage($page);
        $this->highlightedId = $id;
    }

    #[On('province-updated')]
    public function provinceUpdated(?int $id = null): void
    {
        $this->reset(['sortBy', 'sortDirection']);

        if (! $id) {
            return;
        }

        $province = Province::find($id);
        if (! $province) {
            return;
        }

        $beforeCount = Province::where('name', '<', $province->name)->count();
        $page = intdiv($beforeCount, $this->perPage) + 1;

        $this->gotoPage($page);
        $this->highlightedId = $id;
    }


    #[On('province-deleted')]
    public function afterDelete(): void
    {
        $provinces = $this->provinces();

        if ($provinces->isEmpty() && $provinces->currentPage() > 1) {
            $this->previousPage();
        }
    }
};
