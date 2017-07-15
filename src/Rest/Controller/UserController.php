<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 11:42
 */

namespace Rest\Controller;

use Rest\Entity\User;

class UserController extends AbstractController
{
    /**
     * @param $id
     * @return \Rest\Response
     */
    public function get($id)
    {
        $user = $this->getEntityManager()->find(User::class, $id);

        if (!$user) {
            $this->getResponse()->setStatusCode(422)->setContent();
        } else {
            $this->getResponse()->setContent($user->getArrayCopy());
        }

        return $this->getResponse();
    }
}