<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 11:56
 */

namespace Rest\Controller;


use Rest\EntityManager;
use Rest\Request;
use Rest\Response;
use Rest\PhpRenderer;
use Rest\Server;
use Rest\ViewModel;

class AbstractController
{
    const DEFAULT_ACTION = 'index';

    /** @var $response \Rest\Response */
    protected $response = null;

    /** @var  $entityManager \Rest\EntityManager */
    protected $entityManager;

    protected $action;

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
    public function dispatch(Request $request, $action)
    {   
        $this->action = ($action)?:self::DEFAULT_ACTION;
    
        $method = sprintf('%sAction', $this->action);
        if (!method_exists($this, $method)) {
            throw new \RuntimeException("Method `$method` is not implemented"); 
        }

        $view = $this->{$method}();

        return $this->prepareResponse($view);
    }

    /**
     * 
     */
    protected function prepareResponse($view) {

        if(!$view->getLayout()) {
            $view->setLayout(Server::$config['view']['layout']);
        }

        if(!$view->getTemplate()) {
            $class = new \ReflectionClass($this);
            $dir = preg_split('/([[:upper:]][[:lower:]]+)/', $class->getShortName(), null, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
            $view->setTemplate(sprintf('%s/%s.php', $dir[0], $this->action));
        }

        return $view->getResponse();
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
     * @param $id
     * @param $data
     * @return Response
     */
    public function delete($id, $data)
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
     * @return \Rest\EntityManager
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