<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Base\Enums\SchemaNames;

class UserToken extends Migration
{

    public function up()
    {
        Schema::create('security.user_token', function (Blueprint $table) {

            $table->increments('user_token_id');
            $table->integer('user_id')->unsigned();
            $table->integer('token_id')->unsigned()->unique();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')
                ->references('user_id')
                ->on('security.user')
                ->onDelete('cascade');

            $table->foreign('token_id')
                ->references('token_id')
                ->on('security.token')
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
        Schema::drop('security.user_token');
    }
}
