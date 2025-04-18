<?php

use App\Helpers\CryptHelper;
use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('schedule run index', function () {
    $user = User::factory()->create();

    PersonalAccessToken::factory()->create([
        'tokenable_id' => $user->id,
        'tokenable_type' => User::class,
        'token' => hash('sha256', 'test'),
    ]);

    $this->withHeaders([
        'Authorization' => 'Bearer ' . CryptHelper::encryptData('test'),
        'X-Lamdba-Request-Header' => CryptHelper::encryptData(env('AWS_LAMBDA_REQUEST_HEADER')),
    ])->get('/backend/schedule-run')->assertStatus(200);
});
