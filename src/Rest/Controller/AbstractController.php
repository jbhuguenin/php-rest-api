<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 11:56
 */

namespace Rest\Controller;


use Rest\Entity\EntityManager;
use Rest\Request;
use Rest\Response;

class AbstractController
{
    /** @var $response \Rest\Response */
    protected $response = null;

    /** @var  $entityManager \Rest\Entity\EntityManager */
    protected $entityManager;

    /**
     * AbstractController constructor.
     */
    public function __construct()
    {
        if (!$this->getResponse()) {
            $this->setResponse(New Response());
        }

        if(!$this->getEntityManager()) {
            $this->setEntityManager(new EntityManager());
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function dispatch(Request $request)
    {
        switch (strtolower($request->getRequestType())) {
            case 'get':
                $id = $this->getIdentifier($request);
                if ($id) {
                    $return = $this->get($id);
                } else {
                    $return = $this->getList();
                }
                break;

            case 'post':
                // @todo retrieve data from request
                $data = [];
                $return = $this->create($data);
                break;
                
            default:
                $return = $this->getResponse()->setStatusCode(501);
        }

        return $return;
    }

    /**
     * @param $request
     * @return bool
     */
    protected function getIdentifier($request)
    {
        if (!preg_match( "/\d+$/", $request->getUri(), $matches)) {
            return false;
        }

        return $matches[0];
    }

    /**
     * @return Response
     *
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     * @return AbstractController
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @param $id
     * @return Response
     */
    public function get($id)
    {
        return $this->getResponse()->setStatusCode(405);
    }

    /**
     * @return Response
     */
    public function getList()
    {
        return $this->getResponse()->setStatusCode(405);
    }

    public function create($data)
    {
        return $this->getResponse()->setStatusCode(405);
    }

    /**
     * @return \Rest\Entity\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param $entityManager
     * @return $this
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }
}