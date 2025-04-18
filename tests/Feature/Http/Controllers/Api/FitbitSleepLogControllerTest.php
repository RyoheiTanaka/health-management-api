<?php

use App\Models\FitbitSleepLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('sleeps index', function () {
    $this->actingAs(User::factory()->create())->get('/backend/fitbit/sleeps')->assertStatus(200);
});

it('sleeps show', function () {
    FitbitSleepLog::factory()->create();

    $this->actingAs(User::factory()->create())->get('/backend/fitbit/sleeps/1')->assertStatus(200);
});
