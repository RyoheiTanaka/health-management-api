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
        Schema::create('innerscans', function (Blueprint $table) {
            $table->id();
            $table->float('body_weight')->comment('体重');
            $table->float('body_fat_percentage')->comment('体脂肪率');
            $table->date('measurement_date')->comment('記録日');
            $table->boolean('is_data_linkage')->default(false)->comment('データ連携フラグ');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('innerscans');
    }
};
