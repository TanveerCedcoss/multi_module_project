<?php

namespace Multiple\Admin\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

/**
 * ProductController is responsible for CRUD operations on the product
 */
class ProductsController extends Controller
{
    public function indexAction()
    {
    }

    /**
     * addActoin adds a new product to the database
     *
     * @return void
     */
    public function addAction()
    {
        if ($this->request->ispost()) {
            //setting up logger
            $adapter = new Stream('../app/admin/logs/product.log');
            $logger  = new Logger(
                'messages',
                [
                    'main' => $adapter,
                ]
            );
            $values = $this->request->getpost();

            //instantiating MyEscaper class object
            $sanitize = new \Multiple\Admin\Components\Myescaper();
            $insertValues = array(
                "name" => $sanitize->sanitize($values['name']),
                "category" => $sanitize->sanitize($values['category']),
                "price" => $sanitize->sanitize($values['price']),
                "stock" => $sanitize->sanitize($values['stock'])
            );
            //inserting values in the db
            $response = $this->mongo->products->insertOne($insertValues);
            if (($response->getInsertedCount()) > 0) {
                $this->response->redirect('../admin/products/show');
            } else {
                $logger->error('Insertion failed due to some reasons');
            }
        }
    }

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

    /**
     * deleteAction recieves the id of document as param
     * and then deletes it
     *
     * @param [str] $id
     * @return void
     */
    public function deleteAction($id)
    {
        echo $id;
        $val = ["_id" => new \MongoDB\BSON\ObjectId($id)];
        $this->mongo->products->deleteOne($val);
        $this->response->redirect('../admin/products/show');
    }

    /**
     * updationAction updates values of any document in the db according to the updation
     * performed by the admin
     *
     * @param [str] $id
     * @return void
     */
    public function updateAction($id)
    {
        //setting up logger
        $adapter = new Stream('../app/admin/logs/product.log');
        $logger  = new Logger(
            'messages',
            [
                'main' => $adapter,
            ]
        );
        $val = ["_id" => new \MongoDB\BSON\ObjectId($id)];
        $result = $this->mongo->products->findOne($val);
        $this->view->result = $result;
        if ($this->request->ispost()) {
            $val = ["_id" => new \MongoDB\BSON\ObjectId($id)];

            //instantiating MyEscaper class object
            $sanitize = new \Multiple\Admin\Components\Myescaper();

            $up = [
                'name' => $sanitize->sanitize($this->request->getpost('name')),
                'category' => $sanitize->sanitize($this->request->getpost('category')),
                'price' => $this->request->getpost('price'),
                'stock' => $sanitize->sanitize($this->request->getpost('stock'))
            ];
            //updating values in the db
            $response = $this->mongo->products->updateOne($val, ['$set' => $up]);

            if (($response->getModifiedCount()) > 0) {
                $this->response->redirect('../admin/products/show');
            } else {
                $logger->error('Updation failed due to some reasons');
            }
        }
    }
}
