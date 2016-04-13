<?php

namespace DB;

use Sawazon\DAO\DAOProvider;

abstract class DBTaggable extends DBModel
{

    public static $TAG_PATTERN = "%#(?P<tag>[\\w\\d]+)%u"; // # followed by letters and digits

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
        preg_match_all($content, self::$TAG_PATTERN, $tags);

        DAOProvider::get()->updateTags($id, $type, $tags['tag']);
    }

}