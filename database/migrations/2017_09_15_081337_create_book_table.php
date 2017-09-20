<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('book',function (Blueprint $table){
            $table->engine='Innodb';
            $table->charset ='utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->integer('name')->comment('书名');
        
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
        //
        Schema::dropIfExists('book');
    }
}
