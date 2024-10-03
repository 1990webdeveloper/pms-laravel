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
        Schema::create('companies', function (Blueprint $table) {
            $table->id()->comment('Company ID');
            $table->string('subdomain')->comment('Subdomain Name');
            $table->string('name',100)->comment('Name');
            $table->string('profile')->nullable()->comment('Profile');
            $table->string('phone_no')->nullable()->comment('Phone No');
            $table->string('city')->nullable()->comment('City');
            $table->string('country')->nullable()->comment('Country');
            $table->enum('status', ['0', '1', '2'])->default('1')->comment('Status inactive:0/active:1/pending:2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
