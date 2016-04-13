<?php

namespace Sawazon;

use Model\User;

class Controller
{

    /**
     * @param int $access
     * @return bool if current user can access this controler
     */
    public function checkAccess($access = 0)
    {
        if (User::$VISITOR >= $access) return true; // if visitor has access, then everyone has
        $u = user();
        if ($u == null) return false; // there must exist some kind of user
        return $u->user_role >= $access; // user has higher access right
    }

}