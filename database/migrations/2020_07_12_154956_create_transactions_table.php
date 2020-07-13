<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_id');
            $table->string('name', 100);
            $table->string('phone', 50);
            $table->string('address');
            $table->string('subtotal', 50);
            $table->string('tip', 10);
            $table->text('request')->nullable();
            $table->string('status', 10);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
