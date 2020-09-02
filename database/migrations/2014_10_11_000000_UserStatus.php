<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Base\Enums\SchemaNames;
use App\Base\Model\Lang\Translation;
use App\Base\Logic\Lang\Translation\TranslationSave;

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
                'langID' => 'EN',
                'text' => 'Active'
            ],
            [
                'langID' => 'ES',
                'text' => 'Activado'
            ]
        ];
        $inactive = 'inactive';
        $inactiveTranslations = [
            [
                'langID' => 'EN',
                'text' => 'Inactive'
            ],
            [
                'langID' => 'ES',
                'text' => 'Desactivado'
            ]
        ];
        $blocked = 'blocked';
        $blockedTranslations = [
            [
                'langID' => 'EN',
                'text' => 'Blocked'
            ],
            [
                'langID' => 'ES',
                'text' => 'Bloqueado'
            ]
        ];

        $activeTranslation = new TranslationSave(
            new Translation,
            $activeTranslations,
            [
                'code' => $active,
                'isBlocked' => true
            ]
        );
        $activeTranslation->save();

        $inactiveTranslation = new TranslationSave(
            new Translation,
            $inactiveTranslations,
            [
                'code' => $inactive,
                'isBlocked' => true
            ]
        );
        $inactiveTranslation->save();

        $blockedTranslation = new TranslationSave(
            new Translation,
            $blockedTranslations,
            [
                'code' => $blocked,
                'isBlocked' => true
            ]
        );
        $blockedTranslation->save();

        DB::table('security.user_status')->insert([
            [
                'user_status_id' => $active,
                'status_id' => $activeTranslation->id(),
            ],
            [
                'user_status_id' => $inactive,
                'status_id' => $inactiveTranslation->id(),
            ],
            [
                'user_status_id' => $blocked,
                'status_id' => $blockedTranslation->id(),
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
