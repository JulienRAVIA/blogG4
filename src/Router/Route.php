<?php

namespace App\Router;

use Exception;

/**
 * Classe correspondant à une route
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
class Route
{
    /**
     * Méthode de requête (GET ou POST)
     * 
     * @var string
     */
    private $method;

    /**
     * Chemin de la route
     * 
     * @var string
     */
    private $path;

    /** 
     * Controller à instancier
     * 
     * @var string 
     */
    private $controller;

    /** 
     * Méhode du controller à executer lors de l'appel de la route
     * 
     * @var string 
     */
    private $action;

    /**
     * Constructeur
     *
     * @param string $method
     * @param string $path
     * @param string $controller
     * @param string $action
     * @param string $name
     * 
     * @throws Exception si la méthode de requête est incorrecte
     */
    public function __construct(string $method, string $path, string $controller, string $action)
    {
        $method = strtoupper($method);
        if(!in_array($method, Router::METHODS))
            throw new Exception('Méthode incorrecte');

        $this->method     = $method;
        $this->path       = $path;
        $this->controller = $controller;
        $this->action     = $action;
    }

    /**
     * Retourne le chemin de la route
     *
     * @return string
     */
    public function getPath(): string 
    {
        return $this->path;
    }

    /**
     * Retourne le type de méthode de la route (GET ou POST)
     *
     * @return string
     */
    public function getMethod(): string 
    {
        return $this->method;
    }
    
    /**
     * Retourne le controller à instancier
     *
     * @return string
     */
    public function getController(): string 
    {
        return $this->controller;
    }

    /**
     * Retourne la méthode du controller à executer
     *
     * @return string
     */
    public function getAction(): string 
    {
        return $this->action;
    }

    /**
     * Attribue un nouveau chemin à la route
     *
     * @param  string  $path  Chemin de la route
     * 
     * @return  self
     */ 
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
