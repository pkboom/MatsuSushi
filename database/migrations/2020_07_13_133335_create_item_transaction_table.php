<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTransactionTable extends Migration
{
    public function up()
    {
        Schema::create('item_transaction', function (Blueprint $table) {
            $table->integer('transaction_id')->index();
            $table->integer('item_id')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_transaction');
    }
}
