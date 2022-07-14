<?php

namespace Multiple\Merchant\Controllers;

use Phalcon\Mvc\Controller;

/**
 * it is the default controller it gets called when no other controller is called
 */
class IndexController extends Controller
{
    public function indexAction()
    {
        echo '<pre>';
        print_r("hello world");
        echo '<br><br><b>';
        die(__FILE__ . '/line ' . __LINE__);
    }
}
