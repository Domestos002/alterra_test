<?php

namespace Core;

use App\Config;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

/**
 * View
 *
 */

class View
{

    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/Views/$view";

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        preg_match('/(\w*).twig/', $template, $filename);

        if ($twig === null) {
            $loader = new FilesystemLoader(dirname(__DIR__) . '/App/Views');
            $twig = new Environment($loader);
        }

        $args['filename'] = $filename[1];

        $args['env'] = Config::get()->ENVIRONMENT;

        echo $twig->render($template, $args);
    }
}
