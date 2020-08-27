<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Base\Logic\Enum\Schema as SchemaNames;

class Vtext extends Migration
{

    public function up()

    {
        DB::statement(
        "CREATE OR REPLACE VIEW lang.vtext AS  SELECT
            translation.translation_id,
            translation.is_blocked,
            translation.code,
            lang.lang_id,
            lang.active,
            text.text_id,
            CASE
                WHEN originalText.text IS NOT NULL THEN originalText.text
                ELSE text.text
            END AS text,
            CASE
                WHEN originalText.lang_id IS NOT NULL THEN originalText.lang_id
                ELSE text.lang_id
            END AS original_lang_id,
            CASE
                WHEN originalText.lang_id IS NOT NULL THEN true
                ELSE false
            END AS is_available
        FROM lang.translation
            CROSS JOIN lang.lang
            LEFT JOIN lang.text text
                ON text.translation_id = translation.translation_id
                AND text.lang_id = 'EN'
            LEFT JOIN lang.text originalText
                ON originalText.translation_id = translation.translation_id
                AND originalText.lang_id= lang.lang_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW lang.vtext");
    }
}
