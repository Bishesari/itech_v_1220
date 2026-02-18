<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new
#[Layout('layouts.auth')]
#[Title('انتخاب نقش')]
class extends Component
{
    public $bru_s = [];

    public $selectedBruId = null;

    public $selectedColor = null;

    public function mount(): void
    {
        $user = auth()->user();

        // گرفتن همه نقش‌های فعال کاربر
        $this->bru_s = $user->assignments()->with('role', 'branch')->where('is_active', true)->get();

        // انتخاب آخرین نقش انتخاب شده
        $last = $this->bru_s->firstWhere('is_last_selected', true);
        if ($last) {
            $this->selectedBruId = $last->id;
            $this->selectedColor = $last->role?->color ?? 'indigo';

            // ست کردن session
            session(['active_context' => [
                'assignment_id' => $last->id,
                'role_id' => $last->role_id,
                'scope' => $last->role?->scope,
                'institute_id' => $last->institute_id,
                'branch_id' => $last->branch_id,
            ]]);
        }
    }

    public function setBru($id, $color)
    {
        $user = auth()->user();
        $assignment = $user->assignments()->where('id', $id)->first();

        if (! $assignment) {
            $this->addError('selectedRoleId', __('این نقش برای شما فعال نیست.'));

            return;
        }

        $this->selectedBruId = $id;
        $this->selectedColor = $color;

        session(['active_context' => [
            'assignment_id' => $assignment->id,
            'role_id' => $assignment->role?->id,
            'scope' => $assignment->role?->scope,
            'institute_id' => $assignment->institute_id,
            'branch_id' => $assignment->branch_id,
        ]]);

        // update is_last_selected
        $user->assignments()->update(['is_last_selected' => false]);
        $assignment->update(['is_last_selected' => true]);
    }

    public function dashboard()
    {
        if (! $this->selectedBruId) {
            $this->addError('selectedRoleId', __('لطفاً یک نقش انتخاب کنید.'));
            return;
        }

        return redirect()->route('dashboard');
    }
};
