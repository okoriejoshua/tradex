<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsTable extends Migration
{
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('referred_user_id')->nullable(); 
            $table->string('codeused')->nullable(); 
            $table->string('action')->nullable(); 
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('referred_user_id')->references('id')->on('users')->onDelete('set null'); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('referrals');
    }
}
