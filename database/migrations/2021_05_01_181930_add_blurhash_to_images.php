<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlurhashToImages extends Migration
{
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('blurhash', 50)->nullable();
        });
    }
}
