<?php

namespace Controller;

use Dispatch\Dispatcher;
use Model\User;
use Routing\Route;
use Sawazon\Controller;
use Sawazon\DAO\DAOProvider;
use View\NavbarTemplate;
use View\User\UserProfile;

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

    }

    public function editSave()
    {
        
    }
}