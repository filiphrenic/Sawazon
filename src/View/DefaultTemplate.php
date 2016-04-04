<?php

namespace View;

class DefaultTemplate extends Template
{

    public function __construct()
    {
        parent::__construct('main');

        $navbar = new Template('navbar');
        // TODO init navbar with links

        $this->addParam('navbar', $navbar);

        $this->addParam('test-link', 'http://www.google.com');
    }

}