<?php
namespace Seeds\Base;

use Illuminate\Database\Seeder;

use App\Base\Enums\TokenType;
use App\Base\Model\Security\{
    Token,
    User,
    UserToken
};

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($j=0; $j < 20; $j++) {
            $user = factory(User::class)->create();
            $token = Token::create([
                'token' => bin2hex(random_bytes(30)),
                'type' => TokenType::emailVerified(),
                'used_at' => ($user->email_verified) ?  $faker->dateTimeBetween('+1 week', '+1 month') : null ,
                'expire_at' => $faker->dateTimeBetween('+2 month', '+2 month')
            ])->fresh();
            UserToken::create([
                'user_id' => $user->user_id,
                'token_id' => $token->token_id
            ])->fresh();
        };
    }
}
