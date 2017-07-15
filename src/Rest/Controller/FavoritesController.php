<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 15/07/2017
 * Time: 15:49
 */

namespace Rest\Controller;


use Rest\Entity\EntityAbstract;
use Rest\Entity\Favorites;
use Rest\Entity\Song;
use Rest\Entity\User;

class FavoritesController extends AbstractController
{
    /**
     * @param $id
     * @return \Rest\Response
     */
    public function get($id)
    {
        $favorites = $this->getEntityManager()->findBy(Favorites::class, ['user_id' => $id], 'all');

        if (!$favorites) {
            $this->getResponse()->setStatusCode(422)->setContent();
        } else {
            if($favorites instanceof EntityAbstract) {
                $this->getResponse()->setContent($favorites->getArrayCopy());
            } else {
                $this->getResponse()->setContent($favorites);
            }

        }

        return $this->getResponse();
    }

    /**
     * @param $data
     * @return \Rest\Response
     */
    public function create($data)
    {
        if (!isset($data['userId']) || !isset($data['songId'])) {

            $this->getResponse()->setStatusCode(422)->setContent();

        } else {

            if(!$this->getEntityManager()->findBy(User::class, ['id' => $data['userId']])
                || !$this->getEntityManager()->findBy(Song::class, ['id' => $data['songId']])) {

                $this->getResponse()->setStatusCode(422)->setContent();

            } else {
                $favorite = new Favorites();
                $favorite->exchangeArray($data);

                if ($this->getEntityManager()->save($favorite)) {
                    $this->getResponse()->setStatusCode(201)->setContent($favorite->getArrayCopy());
                } else {
                    $this->getResponse()->setStatusCode(422)->setContent('Unprocessable Entity');
                }
            }
        }
        return $this->getResponse();
    }

    /**
     * @param $id
     * @param $data
     * @return \Rest\Response
     */
    public function delete($id, $data)
    {
        if(!$favorites = $this->getEntityManager()->findBy(Favorites::class, ['user_id' => $id], 'all')) {
            $this->getResponse()->setStatusCode(422)->setContent();
        }
        
        $identifiers = [];

        if (isset($data['songId'])) {
            $identifiers[] = ['song_id' => $data['songId']];
        }

        $identifiers[] = ['user_id' => $id];
        if ($this->getEntityManager()->delete(Favorites::class, $identifiers)) {
            $this->getResponse()->setStatusCode(200);
        }

        return $this->getResponse();
    }
}