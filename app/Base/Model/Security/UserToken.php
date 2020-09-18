<?php

declare(strict_types=1);

// phpcs:disable PEAR.Commenting.FileComment.Missing

namespace App\Base\Model\Security;

use App\Base\Logic\Enum\TokenType;
use App\Base\Model\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserToken extends BaseModel
{
    protected $table = 'security.user_token';

    protected $primaryKey = 'user_token_id';

    protected $fillable = [
        'user_id',
        'token_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Return the tokens to belong to this user.
     *
     * @return  HasMany
     */
    public function tokens(): HasMany
    {
        return $this->hasMany('App\Base\Model\Security\Token', 'token_id');
    }

    /**
     * To create a token to validate the user email.
     *
     * @param  int $user_id user to add a new EMAIL_VERIFIED token
     *
     * @return string token
     */
    public static function addValidEmail($user_id) : string
    {
        // @phpstan-ignore-next-line
        $token = Token::add(TokenType::EMAIL_VERIFIED, now()->addHours(24));
        self::create(
            [
                'user_id'  => $user_id,
                'token_id' => $token->token_id,
            ]
        )->fresh();

        return $token->token;
    }

    /**
     * To create to reset password.
     *
     * @param  int $user_id user to add a new FORGOT_PASS token
     *
     * @return string token
     */
    public static function addResetPass($user_id) : string
    {
        // @phpstan-ignore-next-line
        $token = Token::add(TokenType::FORGOT_PASS, now()->addHours(24));
        self::create(
            [
                'user_id'  => $user_id,
                'token_id' => $token->token_id,
            ]
        )->fresh();

        return $token->token;
    }
}
