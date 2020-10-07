<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationProductAndCategory extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // nome da model + id
            $table->foreignId('category_id');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
