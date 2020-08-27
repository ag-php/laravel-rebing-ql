<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Base\Enums\SchemaNames;
use App\Base\Enums\UserStatus;

class User extends Migration
{
    public function up()
    {
        Schema::create('security.user', function (Blueprint $table) {

            $table->increments('user_id');
            $table->string('lang_id', 50)->default('EN');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('user_status_id', 50);
            $table->boolean('email_verified')->default(false);
            $table->rememberToken();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->softDeletes();

            $table->foreign('lang_id')
                ->references('lang_id')
                ->on('lang.lang')
                ->onDelete('restrict');

            $table->foreign('user_status_id')
                ->references('user_status_id')
                ->on('security.user_status')
                ->onDelete('restrict');
        });


        DB::table('security.user')->insert([
            'name' => 'Albert Tjornehoj',
            'email' => 'me@albertcito.com',
            'password' => bcrypt('123456'),
            'user_status_id' => UserStatus::ACTIVE()->getValue(),
            'email_verified' => 1,
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('security.user');
    }
}
