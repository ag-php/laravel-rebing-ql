<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Base\Enums\SchemaNames;

class Text extends Migration
{

    public function up()
    {
        Schema::create('lang.text', function (Blueprint $table) {
            $table->increments('text_id');
            $table->string('lang_id', 50);
            $table->integer('translation_id')->unsigned();
            $table->string('text');

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->unique(['translation_id', 'lang_id']);

            $table->foreign('lang_id')
                    ->references('lang_id')
                    ->on('lang.lang')
                    ->onDelete('restrict');

            $table->foreign('translation_id')
                    ->references('translation_id')
                    ->on('lang.translation')
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
        Schema::dropIfExists('lang.text');
    }
}
