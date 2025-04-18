<?php

use App\Models\FitbitFatLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('fats index', function () {
    $this->actingAs(User::factory()->create())->get('/backend/fitbit/fats')->assertStatus(200);
});

it('fats show', function () {
    FitbitFatLog::factory()->create();

    $this->actingAs(User::factory()->create())->get('/backend/fitbit/fats/1')->assertStatus(200);
});
