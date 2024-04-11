<?php

use App\Models\Company;
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
        Schema::create('secondary_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdfor(Company::class)->nullable()->constrained()->cascadeOnDelete();
            $table->json('secondary_activitie');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secondary_activities');
    }
};
