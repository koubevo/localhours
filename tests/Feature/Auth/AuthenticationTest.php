<?php

use App\Livewire\Admin\CodeInput;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('login screen can be rendered', function () {
    $response = $this->withSession(['is_admin' => false])->get('/');
    $response->assertStatus(200);
});

test('authenticated users are redirected to the dashboard', function () {
    $response = $this->withSession(['is_admin' => true])->get('/');
    $response->assertRedirect(route('admin.dashboard'));
});

test('admin can login with the correct code', function () {
    config(['admin.admin_code' => '123456']);

    Livewire::test(CodeInput::class)
        ->set('code', '123456')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSessionHas('is_admin', true)
        ->assertRedirect(route('admin.dashboard'));
});

test('hacker can not login with the incorrect code', function () {
    config(['admin.admin_code' => '123456']);

    Livewire::test(CodeInput::class)
        ->set('code', '654321')
        ->call('submit')
        ->assertHasErrors('code')
        ->assertSessionMissing('is_admin');
});

test('hacker can not login with the incorrect code too many times', function () {
    config(['admin.admin_code' => '123456']);

    for ($i = 0; $i < 5; $i++) {
        Livewire::test(CodeInput::class)
            ->set('code', '654321')
            ->call('submit')
            ->assertHasErrors('code')
            ->assertSessionMissing('is_admin')
            ->assertDontSee('Příliš mnoho pokusů');
    }

    Livewire::test(CodeInput::class)
        ->set('code', '123456')
        ->call('submit')
        ->assertHasErrors('code')
        ->assertSessionMissing('is_admin')
        ->assertSee('Příliš mnoho pokusů');
});
