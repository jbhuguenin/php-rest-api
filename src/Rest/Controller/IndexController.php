<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 16:52
 */

namespace Rest\Controller;

use Rest\ViewModel;


class IndexController extends AbstractController
{

    public function indexAction() {
        return new ViewModel(['test' => 'toto']);
    }

    public function homeAction() {
        return new ViewModel(['home' => 'home']);
    }
}