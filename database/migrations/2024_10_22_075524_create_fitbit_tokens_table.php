<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fitbit_tokens', function (Blueprint $table) {
            $table->id();
            $table->text('access_token')->comment('アクセストークン');
            $table->text('refresh_token')->comment('リフレッシュトークン');
            $table->dateTime('expiration_datetime')->comment('有効期限');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitbit_tokens');
    }
};
