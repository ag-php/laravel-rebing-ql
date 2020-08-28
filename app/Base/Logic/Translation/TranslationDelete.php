<?php

declare(strict_types=1);
/**
 * To create a translation
 * php version 7.2.10.
 *
 * @category Logic
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     https://albertcito.com
 */

namespace App\Base\Logic\Translation;

use App\Base\Enums\SimpleMessage as SimpleMessageEnum;
use App\Base\Exceptions\MessageError;
use App\Base\Globals\Roles;
use App\Base\GraphQL\Classes\SimpleMessage;
use App\Base\Model\Lang\Translation;
use Illuminate\Support\Collection;

/**
 * To create a translation
 * php version 7.2.10.
 *
 * @category Logic
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     https://albertcito.com
 */
class TranslationDelete
{
    private $translation;

    /**
     * Undocumented function.
     *
     * @param Translation $translation model object to delete
     */
    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    //end __construct()

    /**
     * Delete a translation (if it is not blocked, allowed if it's a super user).
     *
     * @param bool $allowSuperUserDeleteBlocked if is false, the super user cannot delete it
     *
     * @return array
     */
    public function delete(bool $allowSuperUserDeleteBlocked = true): array
    {
        $messages = [new SimpleMessage(
            __(
                'graphql.deleted_success',
                ['item' => $this->translation->translation_id]
            ),
            SimpleMessageEnum::SUCCESS()
        ),
        ];
        // Only super user can delete a blocked translation.
        if ($this->translation->is_blocked) {
            if (Roles::isSuperUser() && $allowSuperUserDeleteBlocked) {
                $messages[] = new SimpleMessage(
                    __(
                        'translation.translation_blocked_deleted',
                        ['translation_id' => $this->translation->translation_id]
                    ),
                    SimpleMessageEnum::WARNING(),
                );
            } else {
                throw with(
                    new MessageError(
                        __(
                            'translation.translation_blocked',
                            ['translation_id' => $this->translation->translation_id]
                        )
                    )
                );
            }
        }

        $this->translation->delete();

        return [
            'data'     => $this->translation,
            'messages' => new Collection($messages),
        ];
    }
}
