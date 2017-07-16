<?php

namespace Rest;

/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 13/07/2017
 * Time: 19:51
 */
class Server
{
    /** @var $router \Rest\Router */
    protected $router;

    public static $config;

    /**
     * @param $config
     * @return Server
     */
    public static function init($config)
    {
        self::$config = $config;

        if(!isset($config['router']) && !isset($config['router']['routes'])) {
            throw new \RuntimeException('invalid router config');
        }

        $router = new Router();
        $router->setRoutes($config['router']['routes']);


        return new self($router);
    }

    /**
     * Server constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * Run Server
     */
    public function run()
    {
        try {

            $request = Request::prepare();
            $routeMatch = $this->getRouter()->matchCurrentRequest($request);
            $response = $this->getRouter()->dispatch($routeMatch, $request);

        } catch (\Exception $e) {
            /**
             * @todo log errors
             */
            $response = new Response('', 500);

        }

        $response->send();
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param $router
     * @return $this
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
}