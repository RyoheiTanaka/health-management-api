<?php

use App\Models\FitbitWeightLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('weights index', function () {
    $this->actingAs(User::factory()->create())->get('/backend/fitbit/weights')->assertStatus(200);
});

it('weights show', function () {
    FitbitWeightLog::factory()->create();

    $this->actingAs(User::factory()->create())->get('/backend/fitbit/weights/1')->assertStatus(200);
});
