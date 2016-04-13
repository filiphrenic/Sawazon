<?php

namespace View;

use View\Product\ProductSmall;

class SearchResults extends Template
{

    public function __construct($words, $idsAndTypes)
    {
        parent::__construct('search_results');
        $this->addParam('title', $this->getTitle($words));
        $this->addParam('content', $this->getContent($idsAndTypes));
    }

    private function getTitle($words)
    {
        if (empty($words)) return "how??";
        $title = [];
        foreach ($words as $w) $title[] = "#$w";
        return implode(' ', $title);
    }

    private function getContent($idsAndTypes)
    {
        $content = [];
        foreach ($idsAndTypes as $m) {
            if ($m['type'] == 'POST')
                $t = new PostSmall($m['id']);
            else // if ($m['type'] == 'PRODUCT')
                $t = new ProductSmall($m['id']);
            $content[] = $t;
        }
        return $content;
    }
}