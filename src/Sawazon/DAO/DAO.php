<?php

namespace Sawazon\DAO;

interface DAO
{
    /**
     * @param int $user_id
     * @return array array of renderable objects
     */
    public function getIndexForUser($user_id = null);
}