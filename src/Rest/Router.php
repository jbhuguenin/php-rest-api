<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 10:23
 */

namespace Rest;


class Router
{
    /**
     * @var array
     */
    protected $routes = [];

    public function __construct()
    {
        return $this;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param array $routes
     * @return Router
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
        return $this;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function matchCurrentRequest(Request $request)
    {
        $filter = function($value) use ($request) {
            $route = strstr($value['route'], ":", true)?:'/';
            return preg_match(sprintf('#^%s(\d+)?$#', $route), $request->getUri());
        };

        if(!$routeMatch = array_filter($this->getRoutes(), $filter)) {
            if($request->getUri() === "/") {
                $routeMatch[] = $this->getRoutes()['default'];
            } else {
                throw new \InvalidArgumentException('route not found');
            }
        }

        return array_values($routeMatch);
    }

    /**
     * @param $route
     * @param Request $request
     * @return mixed
     */
    public function dispatch($route, Request $request)
    {
        $className = $route['controller'];
        if(!class_exists($className)) {
            throw new \RuntimeException(sprintf('classname %s does not exist', $className));
        }

        return (new $className())->dispatch($request);
    }


}