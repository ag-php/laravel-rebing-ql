<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Base\Enums\SchemaNames;

class UserStatusReason extends Migration
{

    public function up()
    {
        Schema::create('security.user_status_reason', function (Blueprint $table) {
            $table->increments('user_status_reason_id');
            $table->integer('user_id')->unsigned();
            $table->string('user_status_id', 50);
            $table->string('reason');

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')
                ->references('user_id')
                ->on('security.user')
                ->onDelete('cascade');

            $table->foreign('user_status_id')
                ->references('user_status_id')
                ->on('security.user_status')
                ->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('security.user_status_reason');
    }
}
