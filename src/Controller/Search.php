<?php

namespace Controller;


use Sawazon\Controller;
use Sawazon\DAO\DAOProvider;
use View\NavbarTemplate;
use View\SearchResults;

class Search extends Controller
{
    public function show()
    {
        $search = cleanHTML(element('search', $_POST, ''));
        preg_match_all("%(?P<words>[\\w\\d]+)%u", $search, $words);
        $words = $words['words'];
        $matches = DAOProvider::get()->getTaggedWith($words);

        $t = new NavbarTemplate();
        $t->addParam('content', new SearchResults($words, $matches));
        $t->render();
    }
}