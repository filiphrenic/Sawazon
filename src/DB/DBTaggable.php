<?php

namespace DB;

use Sawazon\DAO\DAOProvider;

abstract class DBTaggable extends DBModel
{

    public static $TAG_PATTERN = "(?P<tag>[\\w\\d]+)"; // letters and digits

    /**
     * @return string
     */
    public abstract function getTagsColumn();

    protected function afterSave()
    {
        $tcol = $this->getTagsColumn();
        $type = short_name($this);
        $id = $this->getPrimaryKey();

        $content = $this->{$tcol};
        $tags = [];
        preg_match_all('%#' . self::$TAG_PATTERN . '%iu', $content, $tags);

        DAOProvider::get()->updateTags($id, $type, $tags['tag']);
    }

}