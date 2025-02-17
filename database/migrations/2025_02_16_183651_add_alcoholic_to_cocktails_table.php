<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlcoholicToCocktailsTable extends Migration
{
    public function up()
    {
        Schema::table('cocktails', function (Blueprint $table) {
            // Agregamos la columna 'alcoholic'
            $table->string('alcoholic')->nullable()->after('category');
        });
    }

    public function down()
    {
        Schema::table('cocktails', function (Blueprint $table) {
            // Eliminamos la columna en caso de rollback
            $table->dropColumn('alcoholic');
        });
    }
}
