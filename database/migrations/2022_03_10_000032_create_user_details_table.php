<?php

use App\Utils\DBTables;
use App\Utils\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTables::USER_DETAILS, function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on(DBTables::USERS);

            $table->date('date_of_birth')->default(DB::raw('DATE(CURRENT_TIMESTAMP)'));
            $table->char('gender',1)->default(Utils::Male)->comment("M=Male, F=Female");
            $table->float('height')->default(0)->comment("cm");
            $table->float('weight')->default(0)->comment("kg");

            $table->integer('calories')->default(0)->comment("kcal");
            $table->float('vitamin_protein',8,4)->default(0.0)->comment("gram");
            $table->float('vitamin_iron',8,4)->default(0.0)->comment("micro gram");
            $table->float('vitamin_a',8,4)->default(0.0)->comment("micro gram");

//            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTables::USER_DETAILS);
    }
}
