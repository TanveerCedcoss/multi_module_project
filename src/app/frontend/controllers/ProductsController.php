<?php

namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function showAction()
    {
        $result = $this->mongo->products->find();
        $this->view->result = $result;
    }
}
