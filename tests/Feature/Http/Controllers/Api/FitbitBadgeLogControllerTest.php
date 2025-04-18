<?php

use App\Models\FitbitBadgeLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('badges index', function () {
    $this->actingAs(User::factory()->create())->get('/backend/fitbit/badges')->assertStatus(200);
});

it('badges show', function () {
    FitbitBadgeLog::factory()->create();

    $this->actingAs(User::factory()->create())->get('/backend/fitbit/badges/1')->assertStatus(200);
});
