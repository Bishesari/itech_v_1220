<?php

use App\Models\Field;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public string $title = '';

    public bool $showBtn = true;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'min:2', Rule::unique('fields', 'title')],
        ];
    }


    public function save(): void
    {
        $field = Field::create($this->validate());
        $this->modal('new-field')->close();
        $this->dispatch('field-created', id: $field->id);

        Flux::toast(
            text: 'رشته جدید با موفقیت ثبت شد.',
            heading: 'ثبت شد.',
            variant: 'success',
            position: 'top right'
        );
    }

    public function resetForm(): void
    {
        $this->reset();
        $this->resetErrorBag();
    }
};
