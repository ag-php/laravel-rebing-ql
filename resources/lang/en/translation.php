<?php

declare(strict_types=1);

return [
    'translation_blocked' => "Sorry, the translation :translation_id couldn't ".
        "be deleted or updated because it's blocked",
    'translation_blocked_texts' => "Sorry, the translation :translation_id couldn't ".
        "be updated because it's blocked. ".
        'You only may update the empty translations.',
    'translation_blocked_code' => "Sorry, the code's translation :translation_id couldn't ".
        "be updated because it's blocked.",
    'translation_langs_update' => 'The following languages were updated: :langs.',
    'translation_blocked_update' => 'You updated a blocked translation.',
    'translation_blocked_deleted' => 'The blocked translation :translation_id '.
        'was deleted by an super user',
    'deleted' => 'The translation :translation_id was deleted',
    'constrain_error' => 'The translation :translation_id was not deleted. (:detail)',
    'code_duplicate' => 'The code :code is being used in the translation :translation_id',
];
