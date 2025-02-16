<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCocktailsTable extends Migration
{
    public function up()
    {
        Schema::create('cocktails', function (Blueprint $table) {
            $table->id();                    
            $table->string('cocktail_id_api')->nullable()->comment('ID del cóctel según la API');  
            $table->string('name');        
            $table->string('category')->nullable();  
            $table->text('instructions')->nullable(); 
            $table->string('thumbnail')->nullable(); 
            $table->unsignedBigInteger('user_id')->nullable()->comment('ID del usuario que agregó el cóctel');
            $table->timestamps();

            //* Llave foránea para relacionar con usuarios
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cocktails');
    }
}
