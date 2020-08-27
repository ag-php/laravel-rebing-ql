<?php

declare(strict_types=1);

/**
 * Undocumented class
 * php version 7.2.10.
 *
 * @category Model
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     http://www.inspiracion.cl
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
 * @link     http://www.inspiracion.cl
 */
class Lang extends BaseModel
{
    public $incrementing = false;

    protected $table = 'lang.lang';

    protected $primaryKey = 'lang_id';

    protected $fillable = [
        'lang_id',
        'name',
        'local_name',
        'active',
        'is_blocked',
        'created_by',
    ];
}//end class
