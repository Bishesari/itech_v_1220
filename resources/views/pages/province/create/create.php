<?php

use App\Models\Province;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public string $name = '';
    public string $slug = '';

    public bool $showBtn = true;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'min:2', Rule::unique('provinces', 'name')],
            'slug' => ['required', 'min:2', Rule::unique('provinces', 'slug')],
        ];
    }


    public function save(): void
    {
        $province = Province::create($this->validate());
        $this->modal('new-province')->close();
        $this->dispatch('province-created', id: $province->id);

        Flux::toast(
            text: 'استان جدید با موفقیت ثبت شد.',
            heading: 'ثبت شد.',
            variant: 'success',
            position: 'top right'
        );
    }

    public function resetForm(): void
    {
        $this->resetExcept('showBtn');
        $this->resetErrorBag();
    }
};
