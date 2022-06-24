<?php

namespace Multiple\Admin\Controllers;

use Phalcon\Mvc\Controller;

/**
 * LoginController is concerned with the login process of admin
 */
class LoginController extends Controller
{
    public function indexAction()
    {
        if ($this->request->isPost()) {
            $postData = $this->request->getPost();

            $user = $this->mongo->admins->findOne(['password' => $postData['password'], 'email' => $postData['email']]);
            if (count($user) > 0) {
                $this->response->redirect('../admin/products/show');
            } else {
                $this->response->redirect('../admin/login/index');
            }
        }
    }
}
