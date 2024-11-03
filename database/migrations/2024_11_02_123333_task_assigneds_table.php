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
        Schema::create('task_assigneds', function (Blueprint $table) {
            $table->bigInteger('task_groups_id')->unsigned();
            $table->bigInteger('tasks_id')->unsigned();
            $table->bigInteger('developers_id')->unsigned();
            $table->integer('duration');
            $table->integer('week');
            $table->timestamps();
            $table->primary([
                'task_groups_id', 'tasks_id', 'developers_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_assigneds');
    }
};
