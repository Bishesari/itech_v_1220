<?php

use App\Models\Field;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public Field $field;

    public string $title = '';

    protected function rules(): array
    {
        return [
            'title' => ['required', 'min:2', Rule::unique('fields', 'title')->ignore($this->field)],
        ];
    }

    public function mount(): void
    {
        $this->title = $this->field->title;
    }

    public function update(): void
    {
        $validated = $this->validate();

        $this->field->update($validated);

        $this->modal('edit-field-'.$this->field->id)->close();
        $this->dispatch('field-updated', id: $this->field->id);
        Flux::toast(
            text: 'رشته '.$this->title.' با موفقیت ویرایش شد.',
            heading: 'تغییرات اعمال شد.',
            variant: 'warning',
            position: 'top right'
        );

    }
};
