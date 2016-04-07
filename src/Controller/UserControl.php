<?php

namespace Controller;

use Model\User;
use Sawazon\Controller;
use Util\Session;

class UserControl implements Controller
{

    public function login()
    {
        $params = cleanAll(['username', 'password'], $_POST);
        $users = (new User())->loadAll("WHERE username = ? AND password = ?", array_values($params));
        if (empty($users)) echo 0;
        else {
            /** @var User $user */
            $user = $users[0];
            Session::set(Session::$USER_ID, $user->user_id);
            Session::set(Session::$BG_COLOR, $user->background_color);
            Session::set(Session::$CURRENCY, $user->currency);
            echo 1;
        }
    }

    public function checkUsername()
    {
        $username = cleanHTML(element('username', $_POST));
        $users = (new User())->loadAll("WHERE username = ?", [$username]);
        echo empty($users) ? 1 : 0;
    }

    public function checkEmail()
    {
        $email = cleanHTML(element('email', $_POST));
        $users = (new User())->loadAll("WHERE email = ?", [$email]);
        echo empty($users) ? 1 : 0;
    }

    public function register()
    {
        // session has captcha
    }


}