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

namespace App\Base\Globals;

/**
 * Undocumented class
 * php version 7.2.10.
 *
 * @category Model
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     http://www.inspiracion.cl
 */
class Roles
{
    /**
     * To know if the current user_id is the current session user_id  or if it's a super user.
     *
     * number $user_id undocumented
     *
     * @return bool
     */
    public static function isAuth(Int $user_id) : bool
    {
        $user = \Auth::User();

        return $user && ($user->user_id == 1 || $user->user_id == $user_id);
    }

    //end isAuth()

    /**
     * To know if the current session user a super user.
     *
     * @return bool
     */
    public static function isSuperUser() : bool
    {
        $user = \Auth::User();

        return $user && $user->user_id == 1;
    }

    //end isSuperUser()
}//end class
