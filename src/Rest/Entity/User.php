<?php
namespace Rest\Entity;
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 15/07/2017
 * Time: 08:41
 */
class User extends EntityAbstract
{
    /** @var  int */
    protected $id;

    /** @var  string */
    protected $email;

    /** @var  string */
    protected $name;


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}