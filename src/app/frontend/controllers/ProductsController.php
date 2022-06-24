<?php

namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    /**
     * showAction display all the products by fetching it from db and then passing it to the view
     *
     * @return void
     */
    public function showAction()
    {
        $result = $this->mongo->products->find();
        $this->view->result = $result;
    }
}

