<?php

use App\Utils\DBTables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTables::USER_NOTIFICATIONS, function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on(DBTables::USERS);

            $table->tinyInteger('type')->default(1)->comment("1=notify, 2=action");

            $table->string('title');
            $table->text('message')->nullable();

            $table->string('ids')->default("[]")->comment("[] : 1=protein , 2=iron , 3=a");

            $table->tinyInteger('is_read')->default(0)->comment("1=Yes, 0=No");

            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists(DBTables::USER_NOTIFICATIONS);
    }
}
