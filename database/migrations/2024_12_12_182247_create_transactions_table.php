<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_id');
            $table->string('asset')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('asset_value', 10, 2);
            $table->timestamp('duration')->nullable();
            $table->enum('status', ['waiting for pop', 'processing', 'expired', 'successful', 'failed'])->default('waiting for pop');
            $table->string('destination')->nullable();
            $table->string('network')->nullable();
            $table->string('transaction_id');
            $table->string('pop')->nullable();
            $table->string('qrcode')->nullable();
            $table->string('paymethod')->nullable();
            $table->integer('steps')->default(1);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('payment_id')->references('id')->on('payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
