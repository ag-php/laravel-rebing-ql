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
class Token extends BaseModel
{
    protected $table = 'security.token';

    protected $primaryKey = 'token_id';

    protected $fillable = [
        'token',
        'type',
        'used_at',
        'expire_at',
        'created_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'used_at',
        'expire_at',
    ];

    /**
     * Undocumented function.
     *
     * @param string $type      app/Logic/Enum/TokenType.php
     * @param string $expire_at Undocumented
     *
     * @return Token
     */
    public static function add(string $type, string $expire_at = ''): self
    {
        $nowTimestamp = now()->timestamp;
        $token = bin2hex(random_bytes(30).$nowTimestamp);

        return self::create(
            [
                'token'     => $token,
                'type'      => $type,
                'expire_at' => $expire_at,
            ]
        )->fresh();
    }

    //end add()

    /**
     * Get a valid token by type,
     * that does not have been used and is not expired.
     *
     * @param string $token undocumented
     * @param string $type  app/Logic/Enum/TokenType.php
     *
     * @return Token
     */
    public static function getToken(string $token, string $type): self
    {
        $token = self::where(
            [
                'token' => $token,
                'type'  => $type,
            ]
        )
            ->where('expire_at', '>=', now())
            ->whereNull('used_at')
            ->first();

        return $token;
    }

    //end getToken()

    /**
     * Get the user tokens.
     *
     * @return sqlbuilder
     */
    public function users()
    {
        return $this->hasManyThrough(
            'App\Base\Model\Security\User',
            'App\Base\Model\Security\UserToken',
            'token_id',
            'user_id',
            'token_id',
            'user_id'
        );
    }

    //end users()
}//end class
