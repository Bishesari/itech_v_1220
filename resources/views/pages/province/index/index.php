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


    public function toggleStatus(int $provinceId): void
    {
        $province = Province::findOrFail($provinceId);

        $province->update([
            'is_active' => ! $province->is_active,
        ]);

        Flux::toast(
            text: 'وضعیت استان با موفقیت تغییر کرد.',
            heading: 'به‌روزرسانی شد',
            variant: 'warning',
            position: 'top right'
        );
    }

    #[On('province-created')]
    #[On('province-updated')]
    public function focusRecord(?int $id = null): void
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
