<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationUserAndAddress extends Migration
{
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            // nome da model + id
            $table->foreignId('user_id');
        });
    }

    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            //
        });
    }
}
