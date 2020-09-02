<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Base\Enums\SchemaNames;

class Lang extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lang.lang', function (Blueprint $table) {
            $table->string('lang_id', 50)->primary();
            $table->string('name')->unique();
            $table->string('local_name')->unique();
            $table->boolean('active')->default(false);
            $table->boolean('is_blocked')->default(false);

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        DB::table('lang.lang')->insert([
            ['lang_id' => 'EN', 'name' => 'English', 'local_name' => 'English', 'active' => true],
            ['lang_id' => 'ES', 'name' => 'Spanish', 'local_name' => 'Español', 'active' => true],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lang.lang');
    }
}
