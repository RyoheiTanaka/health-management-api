<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('authenticated check index', function () {
    $this->actingAs(User::factory()->create())->get('/backend/auth/check')->assertStatus(200);
});
