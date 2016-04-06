<?php
/**
 * Created by PhpStorm.
 * User: fhrenic
 * Date: 06/04/16
 * Time: 14:58
 */

namespace Controller;

use Model\User;
use Routing\Route;
use Sawazon\Controller;

class UserControll implements Controller
{

    public function login()
    {
        $params = cleanAll(['username', 'password'], $_POST);
        $user_matches = (new User())->loadAll("WHERE username = ? AND password = ?", array_values($params));
        if (empty($user_matches)) {
            var_dump('nema ga', $params);
        } else {
            $user = $user_matches[0];
            $_SESSION['user_id'] = $user->user_id;
            redirect(Route::get('index')->generate());
        }
    }

    public function register()
    {
        // session has captcha
    }
}