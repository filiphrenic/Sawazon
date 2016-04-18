<?php

namespace Controller\Generate;

use Dispatch\Dispatcher;
use Processing\Image\ImageFunc;
use Sawazon\Controller;

class Image extends Controller
{
    
    public function display()
    {
        $r = Dispatcher::getInstance()->getRoute();
        $content = $r->getParam("content");
        $id = $r->getParam("id");

        list($im, $image_path) = ImageFunc::get($content, $id);

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