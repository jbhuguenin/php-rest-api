<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 15/07/2017
 * Time: 16:00
 */

namespace Rest\Entity;


class Favorites extends EntityAbstract
{
    protected $id;

    protected $userId;

    protected $songId;

    protected $favorites;

    public function __construct()
    {
        $this->favorites = [];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Favorites
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     * @return Favorites
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSongId()
    {
        return $this->songId;
    }

    /**
     * @param mixed $songId
     * @return Favorites
     */
    public function setSongId($songId)
    {
        $this->songId = $songId;
        return $this;
    }
}