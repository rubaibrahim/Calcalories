<?php

use App\Utils\DBTables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMealRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTables::MEAL_RECIPES, function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('meal_type_id')->index();
            $table->foreign('meal_type_id')->references('id')->on(DBTables::MEAL_TYPES);

            $table->string('name');
            $table->text('details')->nullable();
            $table->string('img_url',1000);

            $table->integer('calories')->default(0)->comment("kcal");
            $table->float('vitamin_protein',8,4)->default(0.0)->comment("gram");
            $table->float('vitamin_iron',8,4)->default(0.0)->comment("micro gram");
            $table->float('vitamin_a',8,4)->default(0.0)->comment("micro gram");

//            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
//            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTables::MEAL_RECIPES);
    }
}
