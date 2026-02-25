<?php

use App\Models\Role;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

new
#[Title('نقشهای کاربری')]
class extends Component
{
    use WithPagination;

    public string $sortBy = 'id';

    public string $sortDirection = 'desc';

    public ?int $highlightRoleId = null;

    public int $perPage = 10;

    public function sort($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function roles()
    {
        return Role::query()
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    #[On('role-created')]
    public function roleCreated($id = null): void
    {
        $this->reset('sortBy');
        $this->reset('sortDirection');

        $role = Role::find($id);
        if (! $role) {
            return;
        }
        $beforeCount = Role::where('id', '>', $role->id)->count();
        $page = intdiv($beforeCount, $this->perPage) + 1;
        $this->gotoPage($page);
        $this->highlightRoleId = $id;
        $this->dispatch('remove-highlight')->self();
    }

    #[On('role-updated')]
    public function roleUpdated($id = null): void
    {
        $this->highlightRoleId = $id;
        $this->dispatch('remove-highlight')->self();
    }

    #[On('role-deleted')]
    public function afterDelete(): void
    {
        $roles = $this->roles();
        if ($roles->isEmpty() && $roles->currentPage() > 1) {
            $this->previousPage();
        }
    }

    #[On('remove-highlight')]
    public function removeHighlight(): void
    {
        sleep(2);
        $this->highlightRoleId = null;
    }
};
