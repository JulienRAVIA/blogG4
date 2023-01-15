<?php

namespace App;

/**
 * Classe de gestion de session
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
class SessionManager
{
    /**
     * Retourne la valeur correspondante d'une variable de session
     *
     * @param string $key
     */
    public function get(string $key)
    {
        if(!isset($_SESSION[$key]))
            return null;

        return $_SESSION[$key];
    }

    /**
     * Attribue la valeur choisie à une variable de session
     *
     * @param string $key
     * @param $value
     *
     * @return void
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Détruit une variable de session
     *
     * @param string $key
     *
     * @return void
     */
    public function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Détruit la session de l'utilisateur
     *
     * @return void
     */
    public function destroy(): void
    {
        session_destroy();
    }
}