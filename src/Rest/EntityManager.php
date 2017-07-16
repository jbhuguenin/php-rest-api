<?php
namespace Rest;

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
     * @return array|bool|mixed|EntityAbstract
     * @throws \Exception
     */
    public function findAll($className)
    {
        if (!class_exists($className)) {
            throw new \Exception(sprintf('invalid entityname %s given', $className));
        }

        $entityName = (new \ReflectionClass($className))->getShortName();

        $result = $this->dbInstance->query(sprintf("SELECT * FROM %s", strtolower($entityName)), "all");

        return $result;
    }

    /**
     * @param $className
     * @param $identifiers
     * @param string $process
     * @return array|bool|mixed|EntityAbstract
     * @throws \Exception
     */
    public function findBy($className, $identifiers, $process = '')
    {
        if (!class_exists($className)) {
            throw new \Exception(sprintf('invalid entityname %s given', $className));
        }

        $entityName = (new \ReflectionClass($className))->getShortName();

        $result = $this->dbInstance->query(
            sprintf("SELECT * FROM %s WHERE %s = :id", strtolower($entityName), key($identifiers)),
            $process,
            ['id' => reset($identifiers)])
        ;

        if($result && $process == '') {
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
     * @param EntityAbstract $entity
     * @return bool|string
     */
    public function save(EntityAbstract &$entity)
    {
        $entityName = (new \ReflectionClass(get_class($entity)))->getShortName();

        $data = $entity->getArrayCopy();

        /**
         * Bad hack
         * Only insert here
         */
        unset($data['id']);

        $columns = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', implode(",", array_keys($data))));
        $values = implode("','", array_values($data));


        $result = $this->dbInstance->insert(sprintf("INSERT INTO %s (%s) VALUES (%s)", strtolower($entityName), $columns, "'$values'"));

        if ($result) {
            $entity->offsetSet('id', $result);
        }

        return $result;

    }

    /**
     * @param $className
     * @param $identifiers
     * @return bool|string
     * @throws \Exception
     */
    public function delete($className, $identifiers)
    {
        if (!class_exists($className)) {
            throw new \Exception(sprintf('invalid entityname %s given', $className));
        }

        $entityName = (new \ReflectionClass($className))->getShortName();

        $conditions = [];

        foreach ($identifiers as $identifier) {
            $conditions[] = sprintf("%s = %s", key($identifier), current($identifier));
        }

        return $this->dbInstance->query(
            sprintf("DELETE FROM %s WHERE %s", strtolower($entityName), implode(" AND ", $conditions)),
            '',
            [],
            false)
        ;
    }
}