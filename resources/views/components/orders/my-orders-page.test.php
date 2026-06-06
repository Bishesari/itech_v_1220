<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('orders.my-orders-page')
        ->assertStatus(200);
});
