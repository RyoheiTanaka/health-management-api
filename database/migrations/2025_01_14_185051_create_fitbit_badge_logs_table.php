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
        Schema::create('fitbit_badge_logs', function (Blueprint $table) {
            $table->id();
            $table->string('category')->comment('カテゴリ');
            $table->string('badge_type')->comment('タイプ');
            $table->string('name')->comment('名前');
            $table->string('short_name')->comment('短縮名');
            $table->text('description')->comment('説明');
            $table->string('image300px')->comment('画像URL(300px)');
            $table->string('image125px')->comment('画像URL(125px)');
            $table->dateTime('date_time')->comment('達成日');
            $table->integer('times_achieved')->comment('達成回数');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitbit_badge_logs');
    }
};
