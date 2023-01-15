<?php

namespace App\Controller;

/**
 * Controller de la page d'accueil
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
class HomeController extends Controller
{
    /**
     * Page d'accueil, affiche les 15 derniers articles et utilisateurs
     * 
     * @return void
     */
    public function index(): void
    {
        // on séléctionne les 15 derniers articles et utilisateurs
        $articles = array_slice(array_reverse($this->manager->findAll('Contenu')), 0, 15);
        $utilisateurs = array_slice(array_reverse($this->manager->findAll('Utilisateur')), 0, 15);

        echo $this->renderer->render('index', compact('utilisateurs', 'articles'));
    }
}
