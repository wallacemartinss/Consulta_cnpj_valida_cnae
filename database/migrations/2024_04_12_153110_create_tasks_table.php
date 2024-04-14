<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->string('title');
            $table->text('description');
            $table->string('company');
            $table->boolean('urgent')->default(false);
            $table->dateTime('due_date');
            $table->tinyInteger('progress')->default(0);
            $table->string('status')->default('todo');
            $table->integer('order_column');
            $table->timestamps();
        });

        Schema::create('task_user', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Task::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_user');
        Schema::dropIfExists('tasks');
        
    }
};