<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Base\Enums\SchemaNames;
use App\Base\Logic\Translation\TranslationCreate;

class UserStatus extends Migration
{

    public function up()
    {
        Schema::create('security.user_status', function (Blueprint $table) {

            $table->string('user_status_id', 50)->primary();
            $table->integer('status_id')->unique()->unsigned();
            $table->integer('description_id')->nullable();
            $table->boolean('available')->default('true');

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('status_id')
                ->references('translation_id')
                ->on('lang.translation')
                ->onDelete('restrict');

            $table->foreign('description_id')
                ->references('translation_id')
                ->on('lang.translation')
                ->onDelete('restrict');

        });

        $this->addUserStatus();
    }

    private function addUserStatus()
    {
        $active = 'active';
        $activeTranslations = [
            [
                'lang_id' => 'EN',
                'text' => 'Active'
            ],
            [
                'lang_id' => 'ES',
                'text' => 'Activado'
            ]
        ];
        $inactive = 'inactive';
        $inactiveTranslations = [
            [
                'lang_id' => 'EN',
                'text' => 'Inactive'
            ],
            [
                'lang_id' => 'ES',
                'text' => 'Desactivado'
            ]
        ];
        $blocked = 'blocked';
        $blockedTranslations = [
            [
                'lang_id' => 'EN',
                'text' => 'Blocked'
            ],
            [
                'lang_id' => 'ES',
                'text' => 'Bloqueado'
            ]
        ];

        $activeTranslation = TranslationCreate::create(
            $activeTranslations,
            [
                'code' => $active,
                'isBlocked' => true,
            ]
        )->fresh();

        $inactiveTranslation = TranslationCreate::create(
            $inactiveTranslations,
            [
                'code' => $inactive,
                'isBlocked' => true,
            ]
        )->fresh();

        $blockedTranslation = TranslationCreate::create(
            $blockedTranslations,
            [
                'code' => $blocked,
                'isBlocked' => true,
            ]
        )->fresh();

        DB::table('security.user_status')->insert([
            [
                'user_status_id' => $active,
                'status_id' => $activeTranslation->translation_id,
            ],
            [
                'user_status_id' => $inactive,
                'status_id' => $inactiveTranslation->translation_id,
            ],
            [
                'user_status_id' => $blocked,
                'status_id' => $blockedTranslation->translation_id,
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('security.user_status');
    }
}
