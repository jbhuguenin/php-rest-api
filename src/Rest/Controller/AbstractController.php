<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 11:56
 */

namespace Rest\Controller;


use Rest\Request;
use Rest\Response;

class AbstractController
{
    /** @var $response \Rest\Response */
    protected $response = null;

    public function __construct()
    {

        if (!$this->getResponse()) {
            $this->setResponse(New Response());
        }
    }

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

    public function get($id)
    {
        return $this->getResponse()->setStatusCode(405);
    }

    public function getList()
    {
        return $this->getResponse()->setStatusCode(405);
    }

    public function create($data)
    {
        return $this->getResponse()->setStatusCode(405);
    }
}