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

    /**
     * @param $config
     * @return Server
     */
    public static function init($config)
    {
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
     *
     */
    public function run()
    {
        try {
            $request =  new Request($_SERVER['REQUEST_URI'], $_POST, $_GET, getallheaders(), $_SERVER['REQUEST_METHOD']);
            $route = $this->getRouter()->matchCurrentRequest($request);
            $response = $this->getRouter()->dispatch(current($route), $request);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
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