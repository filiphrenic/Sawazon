<?php
/**
 * Created by PhpStorm.
 * User: fhrenic
 * Date: 06/04/16
 * Time: 14:58
 */

namespace Controller;

use Model\User;
use Sawazon\Controller;

class UserControll implements Controller
{

    public function login()
    {
        $params = cleanAll(['username', 'password'], $_POST);
        $users = (new User())->loadAll("WHERE username = ? AND password = ?", array_values($params));
        if (empty($users)) echo 0;
        else {
            $_SESSION['user_id'] = $users[0]->user_id;
            echo 1;
        }

    }

    public function register()
    {
        // session has captcha
    }
}