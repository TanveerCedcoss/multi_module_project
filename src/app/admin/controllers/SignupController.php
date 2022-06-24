<?php

namespace Multiple\Admin\Controllers;

use Phalcon\Mvc\Controller;

/**
 * Signupcontroller is responsible for adding/signing up a new admin
 */
class SignupController extends Controller{

    public function IndexAction(){
       
    }

    /**
     * registerAction recieves values from the post request and
     * then adds them to db as a new collection
     * @return void
     */
    public function registerAction(){
        $values = $this->request->getpost();
      
        $sanitize = new \Multiple\Admin\Components\Myescaper();
        $insertValues = array(
            "name" => $sanitize->sanitize($values['name']),
            "email" => $sanitize->sanitize($values['email']),
            "password" => $sanitize->sanitize($values['password'])
        );

        $response = $this->mongo->admins->insertOne($insertValues);
        $this->response->redirect('../admin/login/index');
    }
}