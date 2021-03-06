<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 14:32
 */

namespace Rest;


class Request
{
    protected $data;

    protected $query;

    protected $headers;

    protected $requestType;

    protected $uri;


    public function __construct()
    {
        return $this;
    }

    public static function prepare()
    {
        return (new self())
            ->setData(file_get_contents('php://input'))
            ->setHeaders(getallheaders())
            ->setRequestType($_SERVER['REQUEST_METHOD'])
            ->setUri($_SERVER['REQUEST_URI'])
        ;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function formatData($data)
    {
        $jsonData = json_decode($data, true);
        parse_str(file_get_contents('php://input'), $data);

        return $jsonData ? : $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return Request
     */
    public function setData($data)
    {
        $this->data = $this->formatData($data);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     * @return Request
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     * @return Request
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestType()
    {
        return $this->requestType;
    }

    /**
     * @param mixed $requestType
     * @return Request
     */
    public function setRequestType($requestType)
    {
        $this->requestType = $requestType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param $uri
     * @return $this
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }
}