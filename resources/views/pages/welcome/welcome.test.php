<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::welcome')
        ->assertStatus(200);
});
