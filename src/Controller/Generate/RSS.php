<?php

namespace Controller\Generate;

use Dispatch\Dispatcher;
use Routing\Route;
use Sawazon\Controller;
use Sawazon\Model;
use Sawazon\RSSable;

class RSS extends Controller
{

    public function get()
    {
        $rss_start = '<?xml version="1.0"?> <rss version="2.0"> <channel>';
        $rss_end = '</channel> </rss>';
        header("Content-Type: application/xml; charset=UTF-8");
        echo $rss_start;

        $r = Dispatcher::getInstance()->getRoute();
        $content = $r->getParam("content");
        $id = $r->getParam("id");

        $Content = ucfirst($content);
        $class = "\\Model\\" . $Content;

        if (!class_exists($class)) {
            echo $rss_end;
            die();
        }
        if (!in_array("Sawazon\\RSSable", class_implements($class))) {
            echo $rss_end;
            die();
        }

        $link = url_base() . Route::get("content")->generate(['content' => $content, 'id' => $id]);
        echo '<title>' . $Content . ' Channel</title>';
        echo '<link>' . $link . '</link>';
        echo '<description>' . $Content . ' no.' . $id . '</description>';

        /** @var Model $model */
        $model = (new $class)->load($id);
        if (null == $model) {
            echo $rss_end;
            die();
        }

        echo '<item>';
        /** @var RSSable $model */
        echo $model->getRSS();
        echo '</item>';

        echo $rss_end;
        die();
    }
}