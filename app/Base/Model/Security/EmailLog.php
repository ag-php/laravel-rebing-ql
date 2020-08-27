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

namespace App\Base\Model\Security;

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
class EmailLog extends BaseModel
{
    protected $table = 'security.email_log';

    protected $primaryKey = 'email_log_id';

    protected $fillable = [
        'user_id_to',
        'to',
        'to_name',
        'user_id_from',
        'from',
        'from_name',
        'subject',
        'html',
        'raw',
        'created_at',
    ];
}//end class
