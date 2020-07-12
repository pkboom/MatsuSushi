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
            $table->string('name', 100);
            $table->string('phone', 50);
            $table->string('address', 150);
            $table->string('subtotal', 50);
            $table->string('tax', 50);
            $table->string('tip', 50);
            $table->string('total', 50);
            $table->text('request')->nullable();
            $table->timestamps();
        });

        Schema::create('menu_transaction', function (Blueprint $table) {
            $table->integer('transaction_id')->index();
            $table->integer('menu_id')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('menu_transaction');
    }
}
