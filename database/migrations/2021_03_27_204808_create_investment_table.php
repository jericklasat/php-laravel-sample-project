<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->nullable();
            $table->foreignId('user_id');
            $table->float('amount');
            $table->string('attachment');
            $table->foreignId('investment_id')->nullable();
            $table->integer('type'); // 1: new, 2: existing
            $table->date('date')->nullable();
            $table->boolean('is_cooldown');
            $table->boolean('is_lock');
            $table->boolean('is_active');
            $table->foreignId('created_by');
            $table->foreignId('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investment');
    }
}
