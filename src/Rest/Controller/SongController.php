<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 11:42
 */

namespace Rest\Controller;

use Rest\Entity\Song;

/**
 * Class SongController
 * @package Rest\Controller
 */
class SongController extends AbstractController
{
    /**
     * @param $id
     * @return \Rest\Response
     */
    public function get($id)
    {
        $song = $this->getEntityManager()->find(Song::class, $id);

        if (!$song) {
            $this->getResponse()->setStatusCode(422)->setContent('Unprocessable Entity');
        } else {
            $this->getResponse()->setContent($song->getArrayCopy());
        }

        return $this->getResponse();
    }

    /**
     * @param $data
     * @return \Rest\Response
     */
    public function create($data)
    {
        if (!isset($data['name']) || !isset($data['time'])) {
            $this->getResponse()->setStatusCode(422)->setContent('Unprocessable Entity');
        } else {
            $song = new Song();
            $song->exchangeArray($data);

            if ($this->getEntityManager()->save($song)) {
                $this->getResponse()->setStatusCode(201)->setContent($song->getArrayCopy());
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
        $songs = $this->getEntityManager()->findAll(Song::class);

        if(!$songs) {
            $songs = [];
        }

        return $this->getResponse()->setContent($songs);
    }
}