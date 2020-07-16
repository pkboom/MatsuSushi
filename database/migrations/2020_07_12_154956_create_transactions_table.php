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
            $table->string('type')->default('delivery');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email')->nullable();
            $table->string('phone', 50);
            $table->string('address')->nullable();
            $table->string('takeout_time', 50)->nullable();
            $table->text('message')->nullable();
            $table->string('subtotal', 50);
            $table->string('tip_percentage', 10);
            $table->string('status', 10)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
