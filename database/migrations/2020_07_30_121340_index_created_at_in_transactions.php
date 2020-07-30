<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IndexCreatedAtInTransactions extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->index('created_at');
        });
    }
}
