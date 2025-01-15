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
        Schema::create('fitbit_weight_logs', function (Blueprint $table) {
            $table->id();
            $table->float('weight')->comment('体重');
            $table->float('bmi')->comment('BMI');
            $table->date('date')->comment('記録日');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitbit_weight_logs');
    }
};
