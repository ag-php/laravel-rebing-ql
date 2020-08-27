<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Base\Enums\SchemaNames;

class Token extends Migration
{

    public function up()
    {
        Schema::create('security.token', function (Blueprint $table) {
            $table->increments('token_id');
            $table->string('token');
            $table->string('type');
            $table->timestamp('used_at')->nullable()->default(null);
            $table->timestamp('expire_at');

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('security.token');
    }
}
