<?php

use App\Models\Province;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public Province $province;

    public string $name = '';

    public string $slug = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'min:2', Rule::unique('provinces', 'name')->ignore($this->province)],
            'slug' => ['required', 'min:2', Rule::unique('provinces', 'slug')->ignore($this->province)],
        ];
    }

    public function mount(): void
    {
        $this->name = $this->province->name;
        $this->slug = $this->province->slug;
    }

    public function update_province(): void
    {
        $this->province->update($this->validate());
        $this->modal('edit-province-'.$this->province->id)->close();
        $this->dispatch('province-updated', id: $this->province->id);

        Flux::toast(
            heading: 'تغییرات اعمال شد.',
            text: 'استان '.$this->name.' با موفقیت ویرایش شد.',
            variant: 'warning',
            position: 'top right'
        );
    }
};
