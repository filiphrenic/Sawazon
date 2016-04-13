<?php

namespace Model;

use DB\DBModel;
use Sawazon\RSSable;

class User extends DBModel implements RSSable
{

    public static $VISITOR = 0;
    public static $REGISTERED = 1;
    public static $MODERATOR = 2;
    public static $ADMINISTRATOR = 3;

    public function getColumnNames()
    {
        return ['user_id', 'username', 'password', 'first_name', 'last_name', 'email',
            'telephone', 'date_of_birth', 'user_role', 'background_color', 'currency',
            'street', 'city', 'country_id'];
    }

    public function getRSS()
    {
        $rss = "<title>$this->username</title>";
        $rss .= "<description>$this->email</description>";
        $rss .= "<author>$this->first_name $this->last_name</author>";
        $rss .= "<category>" . self::roleToString($this->user_role) . "</category>";


        $rss .= "<channel>";
        $rss .= "<title>$this->username's products</title>";
        /** @var Product $product */
        foreach ($this->product_all as $product) {
            $rss .= "<item>" . $product->getRSS() . "</item>";
        }
        $rss .= "</channel>";

        $rss .= "<channel>";
        $rss .= "<title>$this->username's posts</title>";
        /** @var Post $post */
        foreach ($this->post_all as $post) {
            $rss .= "<item>" . $post->getRSS() . "</item>";
        }
        $rss .= "</channel>";

        return $rss;
    }

    /**
     * @param $role user role
     * @return string
     */
    public static function roleToString($role)
    {
        switch ($role) {
            case self::$VISITOR:
                $str = "Visitor";
                break;
            case self::$REGISTERED:
                $str = "Registered user";
                break;
            case self::$MODERATOR:
                $str = "Moderator";
                break;
            case self::$ADMINISTRATOR:
                $str = "Administrator";
                break;
            default:
                $str = "Unknown role";
        }
        return $str;
    }

}