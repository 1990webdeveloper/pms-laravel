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
        Schema::create('pms_user', function (Blueprint $table) {
            $table->id()->comment('User ID');
            $table->string('uuid')->nullable();
            $table->string('name',100)->comment('Name');
            $table->string('email')->comment('Email');
            $table->string('password')->nullable()->comment('Password');
            $table->string('profile')->nullable()->comment('Profile');
            $table->string('phone_no')->nullable()->comment('Phone No');
            $table->string('city')->nullable()->comment('City');
            $table->string('country')->nullable()->comment('Country');
            $table->date('birth_date')->nullable()->comment('Birth Date');
            $table->text('address')->nullable()->comment('Address');
            $table->text('additional_info')->nullable()->comment('Additional info');
            $table->integer('weekly_limit')->nullable()->comment('Weekly limit');
            $table->enum('show_rate', ['0', '1'])->default('1')->comment('Show rate inactive:0/active:1');
            $table->enum('status', ['0', '1', '2'])->default('2')->comment('Status inactive:0/active:1/pending:2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pms_user');
    }
};
