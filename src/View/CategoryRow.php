<?php

namespace View;

class CategoryRow extends Template
{
    /**
     * CategoryRow constructor.
     * @param array $items
     */
    public function __construct($items)
    {
        parent::__construct('category/row');
        $this->addParam('items', $items);
    }
}