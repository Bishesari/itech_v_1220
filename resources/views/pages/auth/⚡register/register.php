<?php

use App\Rules\NCode;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new
#[Layout('layouts.auth')]
#[Title('فرم ثبت نام')]
class extends Component
{
    public string $f_name_fa = '';
    public string $l_name_fa = '';
    public string $n_code = '';
    public string $contact_value = '';
    protected function rules(): array
    {
        return [
            'f_name_fa' => ['required', 'min:2', 'max:30'],
            'l_name_fa' => ['required', 'min:2', 'max:40'],
            'n_code' => ['required', 'digits:10', new NCode, 'unique:profiles'],
            'contact_value' => ['required', 'starts_with:09', 'digits:11'],
        ];
    }

    public function check_inputs(): void
    {
        $this->validate();

    }
};
