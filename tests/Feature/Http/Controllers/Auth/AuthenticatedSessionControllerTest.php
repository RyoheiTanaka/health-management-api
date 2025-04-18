<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('can login', function () {
    User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->get('/sanctum/csrf-cookie');

    $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ])->assertStatus(200);
});

it('can logout', function () {
    $this->actingAs(User::factory()->create())->post('/logout')->assertStatus(200);
});
