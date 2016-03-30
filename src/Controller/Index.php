<?php

namespace Controller;

use Model\Address;
use Model\Country;
use Model\User;
use Sawazon\Controller;

class Index extends Controller
{
    public function display()
    {
        $user = (new User())->load(1);
        $address = (new Address())->load(1);
        $country = (new Country())->load($address->country_id);

        var_dump($user);
        var_dump($address);
        var_dump($country);


    }
}