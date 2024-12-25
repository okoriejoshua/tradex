<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('type', ['admin', 'user'])->default('user');
            $table->enum('role', ['admin', 'super admin'])->default('admin');
            $table->string('referralcode')->nullable();
            $table->string('photo')->nullable();
            $table->string('country')->nullable(); 
            $table->enum('kyc_level', ['none', 'basic', 'advanced'])->default('none');
            $table->string('stage')->nullable();
            $table->string('username')->nullable();
            $table->enum('gender',['male', 'female'])->nullable();
            $table->enum('status', ['active', 'suspended'])->default('active');
            $table->string('phone')->nullable();
            $table->timestamp('dob')->nullable();
            $table->tinyText('address')->nullable();
            $table->string('accupation')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
