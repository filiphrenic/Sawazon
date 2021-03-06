<?php

namespace Controller;

use Model\Country;
use Model\User;
use Processing\Image\ImageUpload;
use Routing\Route;
use Sawazon\Controller;
use Util\Session;
use View\InfoTemplate;
use View\NavbarTemplate;

class UserControl extends Controller
{
    
    public function allUsernames()
    {
        $data = [];
        foreach ((new User())->loadAll() as $u) {
            $data[] = $u->username;
        }
        echoJson($data);
    }

    public function applyAction()
    {
        $params = cleanAll(['users', 'action'], $_POST);

        $usernames = [];
        preg_match_all("%(?P<username>[\\w\\d_]+)%iu", $params['users'], $usernames);
        $usernames = $usernames['username'];

        $placeholders = [];
        foreach ($usernames as $u) {
            $placeholders[] = '?';
        }

        $users = (new User())->loadAll(
            "WHERE username IN (" . implode(',', $placeholders) . ')',
            $usernames
        );

        if (count($users) != count($placeholders)) {
            echo '0';
            return;
        }

        $action = $params['action'];
        if ($action == 'delete') {
            $f = function ($u) {
                $u->delete();
            };
        } else if ($action == 'admin') {
            $f = function ($u) {
                $u->user_role = User::$ADMINISTRATOR;
                $u->save();
            };
        } else {
            echo 0;
            return;
        }

        foreach ($users as $u)
            $f($u);
        echo 1;
    }

    public function login()
    {
        $params = cleanAll(['username', 'password'], $_POST);
        $params['password'] = hashPass($params['password']);
        $users = (new User())->loadAll("WHERE username = ? AND password = ?", array_values($params));

        if (empty($users))
            echo 0;
        else {
            Session::addUser($users[0]);
            echo 1;
        }
    }

    public function checkUsername()
    {
        $username = cleanHTML(element('username', $_POST, ''));
        echo User::exists('username', $username) ? 0 : 1;
    }

    public function checkEmail()
    {
        $email = cleanHTML(element('email', $_POST, ''));
        echo User::exists('email', $email) ? 0 : 1;
    }

    public function register()
    {

        $params = cleanAll(
            ['username', 'password', 'password2',
                'first_name', 'last_name', 'date_of_birth',
                'email', 'telephone',
                'street', 'city', 'country_id',
                'captcha'],
            $_POST
        );

        $captcha = Session::get(Session::$CAPTCHA);

        $registerError = function ($description) {
            $t = new NavbarTemplate();
            $t->addParam('content', new InfoTemplate("Register", $description));
            $t->render();
        };

        if ($captcha != $params['captcha']) {
            $registerError("Captcha wasn't correct. Are you a robot?");
        } else if ($params['password'] != $params['password2'])
            $registerError("Passwords don't match");
        else if (User::exists('username', $params['username']))
            $registerError("Username " . $params['username'] . " already exists");
        else if (User::exists('email', $params['email']))
            $registerError("Email " . $params['email'] . " is already registered");
        else if (!Country::exists('country_id', $params['country_id']))
            $registerError("Undefined country");
        else {

            $user = new User();
            $user->username = $params['username'];
            $user->password = hashPass($params['password']);
            $user->first_name = $params['first_name'];
            $user->last_name = $params['last_name'];
            $user->email = $params['email'];
            $user->telephone = $params['telephone'];
            $user->date_of_birth = $params['date_of_birth'];

            $user->street = $params['street'];
            $user->city = $params['city'];
            $user->country_id = $params['country_id'];

            $user->user_role = User::$REGISTERED;
            $user->background_color = '#ffffff';
            $user->currency = 'HRK';

            // this maybe stupid, but i'm saving images under id.png so i need an id
            $user->save();

            if (!empty($_FILES)) {
                $error = ImageUpload::upload($_FILES['profile_picture'], "user/$user->user_id");
                if ($error) {
                    $user->delete();
                    $registerError($error . " -> profile picture");
                    return;
                }
            }

            // not an error
            $registerError("Registration was successful! Start exploring :)");
        }
    }

    public function logout()
    {
        Session::removeUser();
        echo Route::get('index')->generate();
        //redirectHome();
    }

    public function changeCurrency()
    {
        $new_currency = cleanHTML(element('currency', $_POST, 'HRK'));
        $user = user();
        if ($user == null) return;
        $user->currency = $new_currency;
        $user->save();
        Session::set(Session::$CURRENCY, $new_currency);
    }

    public function changeBGColor()
    {
        $new_bgcolor = cleanHTML(element('bgcolor', $_POST, '#ffffff'));
        $user = user();
        if ($user == null) return;
        $user->bgcolor = $new_bgcolor;
        $user->save();
        Session::set(Session::$BG_COLOR, $new_bgcolor);
    }

}