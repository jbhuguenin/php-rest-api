<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 11:42
 */

namespace Rest\Controller;

use Rest\Entity\User;

class UserController extends AbstractRestfulController
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

    /**
     * @param $data
     * @return \Rest\Response
     */
    public function create($data)
    {
        if (!isset($data['name']) || !isset($data['email'])) {
            $this->getResponse()->setStatusCode(422)->setContent('Unprocessable Entity');
        } else {
            $user = new User();
            $user->exchangeArray($data);

            if ($this->getEntityManager()->save($user)) {
                $this->getResponse()->setStatusCode(201)->setContent($user->getArrayCopy());
            } else {
                $this->getResponse()->setStatusCode(422)->setContent('Unprocessable Entity');
            }
        }

        return $this->getResponse();
    }

    /**
     * @return \Rest\Response
     */
    public function getList()
    {
        $users = $this->getEntityManager()->findAll(User::class) ? : [];

        return $this->getResponse()->setContent($users);
    }
}