<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('payments.payment-result-page')
        ->assertStatus(200);
});
