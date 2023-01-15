<?php

namespace App\Router;

use Exception;
use App\Controller\Controller;
use App\Exception\NotFoundException;

/**
 * Routeur très basique
 * (pas de possibilité de paramètres, pas eu le temps dsl)
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
Class Router
{
    /**
     * Routes de l'application
     * 
     * @var array
     */
    private $routes = array();

    /**
     * Methodes de requête acceptées
     * 
     * @var const
     */
    const METHODS = [
        'GET',
        'POST'
    ];

    /**
     * Ajoute une route à la liste des routes
     * 
     * @param Route $route 
     */
    public function addRoute(Route $route)
    {
        $method = $route->getMethod();

        $this->routes[$method][] = $route;
    }

    /**
     * Ajouter routes collection à la liste des routes
     * 
     * @param Collection $collection
     */
    public function addRoutes(RouteCollection $collection)
    {
        $this->routes = array_merge_recursive($collection->getRoutes(), $this->getRoutes());
    }

    /** 
     * Retourne les routes d'un type de méthode ou toutes les routes si la méthode est invalide
     * 
     * @param string|null $method
     * 
     * @return array
     */
    public function getRoutes(?string $method = null): array
    {
        $method = strtoupper($method);
        if(in_array($method, self::METHODS) && isset($this->routes[$method]))
            return $this->routes[$method];
            
        return $this->routes;
    }

    /**
     * Vérifie si l'url actuelle est enregistrée dans la liste des routes
     * et execute le controller et la méthode associés
     * 
     * @throws Exception si la méthode et le controller ne sont pas executables
     *
     * @return void
     */
    public function match()
    {
        $path = (isset($_SERVER['REDIRECT_URL'])) ? $_SERVER['REDIRECT_URL'] : '/';
        $method = $_SERVER['REQUEST_METHOD'];
        $routes = array_reverse($this->getRoutes($method));

        foreach($routes as $route) {
            if($route->getPath() == $path) {
                $controller = $route->getController();
                $controller = new $controller;
                $action = $route->getAction();
                
                if(is_callable([$controller, $action])) {
                    call_user_func_array([$controller, $action], []);
                    return;
                } else {
                    throw new Exception('Cette méthode ne peut-être appelée');
                }
            }
        }

        throw new NotFoundException('Page non trouvée', 'Il semblerait que cette page n\'existe pas');
    }
}