<?php

namespace App\Router;

/**
 * Collection de routes (pour attribuer à plusieurs routes un même prefixe de route)
 * Exemple : /article/* si $path = '/article'
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
class RouteCollection
{
    /**
     * Routes de la collection
     *
     * @var array
     */
    private $routes = [];

    /**
     * Préfixe (chemin) par défaut des routes qui seront contenues dans la Collection
     * 
     * @var string
     */
    private $path;

    /**
     * Constructeur
     * On ajoute le préfixe des routes qui seront contenues dans cette collection
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Recupère le chemin de la collection
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Ajoute une route aux routes
     *
     * @param Route $route
     *
     * @return void
     */
    public function addRoute(Route $route): void
    {
        $path = $this->path . $route->getPath();
        $route->setPath($path);

        $this->routes[$route->getMethod()][] = $route;
    }

    /**
     * Retourne les routes de la collection
     *
     * @param string|null $method
     *
     * @return array
     */
    public function getRoutes(?string $method = null): array
    {
        $method = strtoupper($method);

        if(in_array($method, Router::METHODS) && isset($this->routes[$method]))
            return $this->routes[$method];
            
        return $this->routes;
    }
}
