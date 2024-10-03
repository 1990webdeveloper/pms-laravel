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
        Schema::create('users_companies', function (Blueprint $table) {
              //FOREIGN KEY CONSTRAINTS
              $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
              $table->foreignId('company_id')->references('id')->on('companies')->onDelete('cascade');
  
              //SETTING THE PRIMARY KEYS
              $table->primary(['user_id', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_companies');
    }
};
