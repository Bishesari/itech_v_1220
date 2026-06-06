<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('checkout.checkout-page')
        ->assertStatus(200);
});
