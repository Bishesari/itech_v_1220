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

    public function update(): void
    {
        $validated = $this->validate();

        $this->province->update($validated);

        $this->modal('edit-province-'.$this->province->id)->close();
        $this->dispatch('province-updated', id: $this->province->id);
        Flux::toast(
            text: 'استان '.$this->name.' با موفقیت ویرایش شد.',
            heading: 'تغییرات اعمال شد.',
            variant: 'warning',
            position: 'top right'
        );

    }
};
