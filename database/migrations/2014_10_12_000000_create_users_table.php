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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('User ID');
            $table->string('uuid')->nullable();
            $table->string('name')->comment('Name');
            $table->string('email')->unique()->comment('Email');
            $table->timestamp('email_verified_at')->nullable()->comment('Email Verified At');
            $table->string('password')->comment('Password');
            $table->string('profile')->nullable()->comment('Profile');
            $table->string('phone_no')->nullable()->comment('Phone No');
            $table->string('city')->nullable()->comment('City');
            $table->string('country')->nullable()->comment('Country');
            $table->date('birth_date')->nullable()->comment('Birth Date');
            $table->enum('status', ['0', '1', '2'])->default('0')->comment('Status inactive:0/active:1/pending:2');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
