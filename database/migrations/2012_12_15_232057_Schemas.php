<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Base\Enums\SchemaNames;

class Schemas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        $dbUser = env('DB_USERNAME');
        foreach (SchemaNames::MAP_VALUE as $schemaName) {
            DB::statement(
                'CREATE SCHEMA IF NOT EXISTS '. $schemaName .' AUTHORIZATION '. $dbUser .';'
            );
        }
        DB::statement('CREATE EXTENSION IF NOT EXISTS unaccent WITH SCHEMA lang;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP EXTENSION IF EXISTS unaccent;');
        foreach (SchemaNames::MAP_VALUE as $schemaName) {
            DB::statement('DROP SCHEMA IF EXISTS '.$schemaName.' CASCADE; ');
        }
    }
}
