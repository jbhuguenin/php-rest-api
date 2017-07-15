<?php
namespace Rest\Entity;

/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 15/07/2017
 * Time: 08:41
 */
class Song extends EntityAbstract
{
    protected $id;

    protected $name;

    protected $time;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Song
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Song
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     * @return Song
     */
    public function setTime($time)
    {
        $this->time = date("i:s",$time);
        return $this;
    }
}