<?php

use App\Livewire\Sistema\UserForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('it can update user permissions using cliente function', function () {
    $admin = User::factory()->sistema()->create();
    $targetUser = User::factory()->cliente()->create();

    Livewire::actingAs($admin)
        ->test(UserForm::class)
        ->call('loadUser', $targetUser->id)
        ->set('funcao', 'cliente')
        ->set('can_access_dashboard', true)
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('notify');

    $targetUser->refresh();
    expect($targetUser->funcao)->toBe('cliente');
    expect($targetUser->can_access_dashboard)->toBe(1);
});

test('it can update user permissions to admin', function () {
    $admin = User::factory()->sistema()->create();
    $targetUser = User::factory()->cliente()->create();

    Livewire::actingAs($admin)
        ->test(UserForm::class)
        ->call('loadUser', $targetUser->id)
        ->set('funcao', 'admin')
        ->call('save')
        ->assertHasNoErrors();

    $targetUser->refresh();
    expect($targetUser->funcao)->toBe('admin');
});
