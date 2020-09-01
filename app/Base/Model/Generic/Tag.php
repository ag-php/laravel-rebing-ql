<?php

declare(strict_types=1);

namespace App\Base\Model\Generic;

use App\Base\Model\BaseModel;

class Tag extends BaseModel
{
    protected $table = 'generic.tag';

    protected $primaryKey = 'tag_id';

    protected $fillable = [
        'translation_id',
        'is_blocked',
    ];
}
