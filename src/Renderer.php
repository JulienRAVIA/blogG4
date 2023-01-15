<?php

namespace App;

/**
 * Moteur de template
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 * @author Grafikart (https://grafikart.fr) (flemme de le faire de zéro, je me suis librement inspiré en refaisant à ma sauce à 90%)
 */
class Renderer 
{
    /**
     * Gestionnaire de session
     * 
     * @var SessionManager
     */
    private $session;

    /**
     * Variables globalement accessibles pour toutes les vues
     * 
     * @var array
     */
    private $globals = [];

    /**
     * Constructeur
     * On passe le SessionManager pour pouvoir récupérer les variables de sessions dans les vues
     *
     * @param SessionManager $session
     */
    public function __construct(SessionManager $session) 
    {
        $this->session = $session;
    }

    /**
     * Permet de rendre une vue
     * Le chemin peut être précisé avec des namespace rajoutés via addPath()
     * 
     * @param string $view
     * @param array $params
     * 
     * @return string
     */
    public function render(string $view, array $params = []): string {
        $path = '../views/';
        $path .= $view . '.php';
        ob_start();
        $renderer = $this;
        $session = $this->session;
        extract($this->globals);
        extract($params);
        require($path);
        return ob_get_clean();
    }

    /**
     * Permet de rajouter des variables globales à toutes les vues
     *
     * @param string $key
     * @param mixed $value
     */
    public function addGlobal(string $key, $value): void {
        $this->globals[$key] = $value;
    }
}