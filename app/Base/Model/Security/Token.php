<?php

declare(strict_types=1);

namespace App\Base\Model\Security;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Base\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

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
     * @param Carbon $expireAt Undocumented
     *
     * @return Token
     */
    public static function add(string $type, Carbon $expireAt = null): Token
    {
        $nowTimestamp = now()->timestamp;
        $token = bin2hex(random_bytes(30).$nowTimestamp);

        return Token::create(
            [
                'token'     => $token,
                'type'      => $type,
                'expire_at' => $expireAt,
            ]
        );
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
    public static function getToken(string $token, string $type): Token
    {
        $token = Token::where(
            [
                'token' => $token,
                'type'  => $type,
            ]
        )
            ->where('expire_at', '>=', now())
            ->whereNull('used_at')
            ->first();

        if (!$token) {
            throw new \Exception("Token does not exist");
        }

        return $token;
    }

    //end getToken()

    /**
     * Get the user tokens.
     *
     * @return HasManyThrough
     */
    public function users(): HasManyThrough
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

}
