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
        Schema::create('contests', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->enum('access_level', ['ADMIN','NORMAL', 'VIP']);
        $table->dateTime('start_time');
        $table->dateTime('end_time');
        $table->float('prize_amount');
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
        Schema::dropIfExists('contests');
    }
};
