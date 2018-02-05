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

    public function getList()
    {
        return new ViewModel(['test' => 'toto'], ['template' => 'Index/get-list.php']);
    }
}