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
}