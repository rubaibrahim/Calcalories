<?php

use App\Utils\DBTables;
use App\Utils\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTables::USERS, function (Blueprint $table) {
            $table->id();

            $table->string('name',255)->nullable();
            $table->string('email',255)->unique();
            $table->string('password',255);

            // To send push notifications to user
            $table->string('fcm_token',255)->nullable();

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
        Schema::dropIfExists(DBTables::USERS);
    }
}
