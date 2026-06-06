<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('booklets.show-booklet-page')
        ->assertStatus(200);
});
