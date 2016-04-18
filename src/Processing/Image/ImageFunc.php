<?php

namespace Processing\Image;

class ImageFunc
{
    public static $IMAGES_DIR = __DIR__ . "/../../../images";


    public static function path($content, $id)
    {
        $folder = self::$IMAGES_DIR . "/$content";
        if (!file_exists($folder))
            strange_behaviour("no image folder for $content");

        $image_path = "$folder/$id.png";

        $wrong = null;
        if (!file_exists($image_path)) {
            $wrong = "$folder/image-not-found.png";
        }

        return [$image_path, $wrong];
    }


    public static function get($content, $id)
    {
        list($image_path, $wrong) = self::path($content, $id);
        if ($wrong != null) $image_path = $wrong;
        $im = imagecreatefrompng($image_path);
        return [$im, $image_path];
    }

}