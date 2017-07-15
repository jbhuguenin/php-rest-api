<?php
namespace Rest\Entity;

use Rest\DbAdapter;
use Rest\Server;

/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 18:53
 */
class EntityManager
{
    /** @var DbAdapter  */
    protected $dbInstance;
    
    public function __construct()
    {
        $config = Server::$config;

        if(!$config['database']) {
            throw new Exception('missing database config');
        }

        $this->dbInstance = DbAdapter::getInstance($config['database']);
    }


    /**
     * @param $className
     * @param $id
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function find($className, $id)
    {
        if (!class_exists($className)) {
            throw new \Exception(sprintf('invalid entityname %s given', $className));
        }

        $entityName = (new \ReflectionClass($className))->getShortName();

        $result = $this->dbInstance->query(
            sprintf("SELECT * FROM %s WHERE id = :id", strtolower($entityName)),
            '',
            ['id' => $id])
        ;

        if($result) {
            $entity = new $className();
            if (!$entity instanceof EntityAbstract) {
                throw new \Exception('entity must implements EntityAbstract');
            }

            $return = $entity->exchangeArray($result);
        } else {
            $return = $result;
        }

        return $return;
    }

    /**
     * @param $className
     * @param $identifiers
     * @return array|bool|mixed|EntityAbstract
     * @throws \Exception
     */
    public function findBy($className, $identifiers)
    {
        if (!class_exists($className)) {
            throw new \Exception(sprintf('invalid entityname %s given', $className));
        }

        $entityName = (new \ReflectionClass($className))->getShortName();

        $result = $this->dbInstance->query(
            sprintf("SELECT * FROM %s WHERE %s = :id", strtolower($entityName), key($identifiers)),
            '',
            ['id' => reset($identifiers)])
        ;

        if($result) {
            $entity = new $className();
            if (!$entity instanceof EntityAbstract) {
                throw new \Exception('entity must implements EntityAbstract');
            }

            $return = $entity->exchangeArray($result);
        } else {
            $return = $result;
        }

        return $return;
    }




}