<?php

declare(strict_types=1);

/**
 * Undocumented class
 * php version 7.2.10.
 *
 * @category Model
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     https://albertcito.com
 */

namespace App\Base\Model\Lang;

use App\Base\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Undocumented class
 * php version 7.2.10.
 *
 * @category Model
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     https://albertcito.com
 */
class VText extends BaseModel
{
    protected $table = 'lang.vtext';

    protected $primaryKey = 'text_id';

    protected $fillable = [
        'translation_id',
        'is_blocked',
        'code',
        'lang_id',
        'text_id',
        'text',
        'original_lang_id',
        'is_available',
        'active',
    ];
}//end class
