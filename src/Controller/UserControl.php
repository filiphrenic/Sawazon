<?php

namespace Controller;

use Dispatch\Dispatcher;
use Model\Country;
use Model\User;
use Processing\Image\ImageUpload;
use Sawazon\Controller;
use Sawazon\DAO\DAOProvider;
use Util\Session;
use View\InfoTemplate;
use View\NavbarTemplate;
use View\User\UserProfile;

class UserControl extends Controller
{

    public function checkFollows()
    {
        $params = cleanAll(['follower', 'followee'], $_POST);
        $b = DAOProvider::get()->checkFollows($params['follower'], $params['followee']);
        echo $b ? 1 : 0;
    }

    public function modifyFollow()
    {
        $params = cleanAll(['follower', 'followee', 'action'], $_POST);
        DAOProvider::get()->modifyFollow(
            $params['follower'],
            $params['followee'],
            $params['action']
        );
    }


    public function show()
    {
        $r = Dispatcher::getInstance()->getRoute();
        $user_id = $r->getParam('id');

        // TODO check exists

        $user = (new User())->load($user_id);
        $t = new NavbarTemplate();
        $t->addParam('content', new UserProfile($user));
        $t->render();
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
        redirectHome();
    }

}