<?php

namespace Controller;

use Dispatch\Dispatcher;
use Model\Country;
use Model\User;
use Routing\Route;
use Sawazon\Controller;
use Sawazon\DAO\DAOProvider;
use View\InfoTemplate;
use View\NavbarTemplate;
use View\User\UserProfile;
use View\User\UserProfileEdit;

class UserProfileControl extends Controller
{
    public function show()
    {
        $r = Dispatcher::getInstance()->getRoute();
        $user_id = $r->getParam('id');

        if (!User::exists('user_id', $user_id)) {
            redirect(Route::get('error')->generate(['code' => '404']));
            return;
        }

        $user = (new User())->load($user_id);
        $t = new NavbarTemplate();
        $t->addParam('content', new UserProfile($user));
        $t->render();
    }

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

    public function editShow()
    {
        $r = Dispatcher::getInstance()->getRoute();
        $user_id = $r->getParam('id');

        if (!User::exists('user_id', $user_id)) {
            redirect(Route::get('error')->generate(['code' => '404']));
            return;
        }

        $user = user();
        if ($user == null or $user->user_id != $user_id) {
            redirect(Route::get('error')->generate(['code' => '404']));
            return;
        }

        $user = (new User())->load($user_id);
        $t = new NavbarTemplate();
        $t->addParam('content', new UserProfileEdit($user));
        $t->render();


    }

    public function editSave()
    {
        $params = cleanAll(
            ['user_id', 'first_name', 'last_name', 'date_of_birth',
                'email', 'telephone', 'street', 'city', 'country_id'],
            $_POST
        );

        $error = function ($description) {
            $t = new NavbarTemplate();
            $t->addParam('content', new InfoTemplate("Edit profile", $description));
            $t->render();
        };

        $user = (new User())->load($params['user_id']);
        if ($user == null) {
            $error("User doesn't exist");
            return;
        }

        $country_id = $params['country_id'];
        if ($country_id != '') {
            if (!Country::exists('country_id', $country_id)) {
                $error("Undefined country");
                return;
            }
            $user->country_id = $country_id;
        }

        $user->first_name = $params['first_name'];
        $user->last_name = $params['last_name'];
        $user->email = $params['email'];
        $user->telephone = $params['telephone'];
        $user->date_of_birth = $params['date_of_birth'];
        $user->street = $params['street'];
        $user->city = $params['city'];

        $user->save();

        // not an error
        $error("Successfully updated your information");
    }

    public function password()
    {

        $params = cleanAll(
            ['user_id', 'old_password', 'new_password', 'new_password2'],
            $_POST
        );

        $error = function ($description) {
            $t = new NavbarTemplate();
            $t->addParam('content', new InfoTemplate("Password", $description));
            $t->render();
        };

        $u = (new User())->load($params['user_id']);
        if ($u == null) {
            $error("User doesn't exist.");
            return;
        }

        if (hashPass($params['old_password']) != $u->password) {
            $error("Old password doesn't match.");
            return;
        }

        if ($params['new_password'] != $params['new_password2']) {
            $error("New passwords don't match.");
            return;
        }

        // ok

        $u->password = hashPass($params['old_password']);
        $u->save();

        // not error
        $error("Password successfully changed!");
    }


}