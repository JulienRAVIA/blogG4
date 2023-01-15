<?php

namespace App\Controller;

use App\{ Manager, Renderer, SessionManager };

/**
 * Controller de base (avec dépendances injectées)
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
abstract class Controller
{
    /**
     * Instanciation des "services"
     */
    public function __construct()
    {
        $this->manager = new Manager('blog_g4');
        $this->session = new SessionManager;
        $this->renderer = new Renderer($this->session);
    }
}
