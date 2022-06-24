<?php

namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    /**
     * showAction display all the products by fetching it from db and then passing it to the view
     *
     * @return void
     */
    public function indexAction()
    {
        echo 'user';
    }
}
