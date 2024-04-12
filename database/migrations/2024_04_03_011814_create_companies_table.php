<?php

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
      public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdfor(User::class)->constrained();
            $table->string('document_number')->unique();
            $table->string('released')->nullable();            
            $table->string('open_date')->nullable();
            $table->string('fantasy_name')->nullable();
            $table->string('social_reason')->nullable();
            $table->string('company_size')->nullable();
            $table->string('legal_nature')->nullable();
            $table->string('share_capital')->nullable();
            $table->string('status')->nullable();;
            $table->string('simei_situation')->nullable();
            $table->string('simple_situation')->nullable();
            $table->string('principal_cnae_description')->nullable();
            $table->string('principal_cnae_code')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('cellphone')->nullable();           
            $table->string('especial_situation')->nullable();
            $table->string('registration_situation_reason')->nullable();
            $table->string('registration_situation_reason_data')->nullable(); 
            $table->timestamps();
        });

      
    }

    

     public function down(): void
    {
        Schema::dropIfExists('companies');
      
    }
};
