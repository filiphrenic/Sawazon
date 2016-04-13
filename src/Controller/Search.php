<?php

namespace Controller;


use DB\DBTaggable;
use Sawazon\Controller;
use Sawazon\DAO\DAOProvider;
use View\NavbarTemplate;
use View\SearchResults;

class Search extends Controller
{
    public function show()
    {
        $search = cleanHTML(element('search', $_POST, ''));
        preg_match_all('%'. DBTaggable::$TAG_PATTERN . '%u', $search, $tags);
        $tags = $tags['tag'];
        $matches = DAOProvider::get()->getTaggedWith($tags);

        $t = new NavbarTemplate();
        $t->addParam('content', new SearchResults($tags, $matches));
        $t->render();
    }
}