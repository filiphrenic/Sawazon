<?php

namespace Controller\Generate;

use Dispatch\Dispatcher;
use Sawazon\Controller;

class Image extends Controller
{

    private static $ROOT_DIR = __DIR__ . "/../../../images";

    public function display()
    {
        $r = Dispatcher::getInstance()->getRoute();
        $content = $r->getParam("content");
        $id = $r->getParam("id");

        $folder = self::$ROOT_DIR . "/$content";
        if (!file_exists($folder))
            strange_behaviour("no image folder for $content");

        $image_path = "$folder/$id.png";
        if (!file_exists($image_path)) {
            $image_path = "$folder/image-not-found.png";
        }
        $im = imagecreatefrompng($image_path);

        $type = exif_imagetype($image_path);
        $mime = image_type_to_mime_type($type);

        // render image
        header("Content-Type: " . $mime);
        switch ($type) {
            case IMAGETYPE_JPEG:
            case IMAGETYPE_JPEG2000:
                imagejpeg($im);
                break;
            case IMAGETYPE_PNG:
                imagepng($im);
                break;
            case IMAGETYPE_GIF:
                imagegif($im);
                break;
            default:
                imagepng($im);
        }

        imagedestroy($im);
        die();
    }

}