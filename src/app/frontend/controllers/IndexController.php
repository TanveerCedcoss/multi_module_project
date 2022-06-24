<?php

namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

/**
 * it is the default controller it gets called when no other controller is called
 */
class IndexController extends Controller
{
    public function indexAction()
    {
        $this->response->redirect('../home');
    }
}
