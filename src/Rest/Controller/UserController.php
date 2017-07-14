<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 11:42
 */

namespace Rest\Controller;


class UserController extends AbstractController
{

    public function get($id)
    {
        return $this->getResponse()->setContent(['toto' => 1]);
    }
}