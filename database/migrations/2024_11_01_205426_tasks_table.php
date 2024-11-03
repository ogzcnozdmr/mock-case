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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('task_groups_id')->unsigned();
            $table->bigInteger('task_datas_id')->unsigned();
            $table->integer('json_data_id');
            $table->integer('duration');
            $table->integer('difficulty');
            $table->timestamps();
            $table->foreign('task_groups_id')->references('id')->on('task_groups');
            $table->foreign('task_datas_id')->references('id')->on('task_datas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
