<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 16:52
 */

namespace Rest\Controller;


class IndexController extends AbstractController
{

    public function getList()
    {
        return $this->getResponse()->setContent(json_encode('test page'));
    }
}