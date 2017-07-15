<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 15/07/2017
 * Time: 15:49
 */

namespace Rest\Controller;


use Rest\Entity\Favorites;

class FavoritesController extends AbstractController
{
    /**
     * @param $id
     * @return \Rest\Response
     */
    public function get($id)
    {
        $favorites = $this->getEntityManager()->findBy(Favorites::class, ['user_id' => $id]);

        if (!$favorites) {
            $this->getResponse()->setStatusCode(422)->setContent();
        } else {
            $this->getResponse()->setContent($favorites->getArrayCopy());
        }

        return $this->getResponse();
    }
}