<?php

namespace App\Controllers;

use App\Models\Contact;
use \Core\View;

/**
 * Home controller
 *
 */

class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Home/index.twig');
    }

    /**
     *
     * @return void
     */
    public function taskCreateAction()
    {
        $task = new Contact($_POST);

        $task->validate();

        var_dump($task->errors);
    }
}
