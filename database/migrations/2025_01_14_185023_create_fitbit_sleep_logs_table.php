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
        Schema::create('fitbit_sleep_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('duration')->comment('睡眠時間');
            $table->smallInteger('efficiency')->comment('睡眠スコア');
            $table->smallInteger('info_code')->comment('データ品質コード');
            $table->date('date_of_sleep')->comment('睡眠日');
            $table->dateTime('end_time')->comment('睡眠終了日時');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitbit_sleep_logs');
    }
};
