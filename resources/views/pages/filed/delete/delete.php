<?php

use App\Models\Field;
use Livewire\Component;

new class extends Component
{
    public Field $field;

    public string $title = '';

    public function mount(): void
    {
        $this->title = $this->field->title;
    }

    public function delete(): void
    {
        $fieldTitle = $this->field->title;
        $fieldId = $this->field->id;

        $this->field->delete();

        $this->modal('field-delete-'.$fieldId)->close();
        $this->dispatch('field-deleted');

        Flux::toast(
            text: "رشته {$fieldTitle} با موفقیت حذف شد.",
            heading: 'حذف شد.',
            variant: 'danger',
            position: 'top right'
        );
    }
};
