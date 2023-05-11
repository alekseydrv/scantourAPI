<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("login");
            $table->string("password");
            $table->integer("tarif");
            $table->integer('tourdate_id');
            $table->text("comment");
            $table->integer("sngl");
            $table->integer("dbl");
            $table->integer("twin");
            $table->integer("trpl");
            $table->integer("qdrpl");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
