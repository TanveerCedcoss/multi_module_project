<?php

namespace Multiple\Merchant\Controllers;

use Phalcon\Mvc\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $this->assets->addCss("/css/style.css");
        // echo '<pre>';
        // print_r($this->assets->addJs("/js/script.js"));
        // die(__FILE__.'/line '.__LINE__);
        $this->assets->addJs("/js/script.js");
    }
}
