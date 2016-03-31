<?php

namespace Sawazon;

interface Renderable
{
    /**
     * @return string html representation of this object
     */
    public function render();
}
