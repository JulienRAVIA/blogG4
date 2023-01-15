<?php
session_start();
include '../vendor/autoload.php';

use App\Controller\{ HomeController, ArticleController, UtilisateurController };
use App\Router\ { Router, Route, RouteCollection };

$router = new Router;

// routes pour les articles
$collection = new RouteCollection('/article');
$collection->addRoute(new Route('GET', '', ArticleController::class, 'show'));
$collection->addRoute(new Route('GET', '/nouveau', ArticleController::class, 'form'));
$collection->addRoute(new Route('POST', '/nouveau', ArticleController::class, 'handler'));
$collection->addRoute(new Route('GET', '/edition', ArticleController::class, 'form'));
$collection->addRoute(new Route('POST', '/edition', ArticleController::class, 'handler'));
$collection->addRoute(new Route('GET', '/suppression', ArticleController::class, 'delete'));
$router->addRoutes($collection);

// routes de profil
$collection = new RouteCollection('/profil');
$collection->addRoute(new Route('GET', '', UtilisateurController::class, 'show'));
$collection->addRoute(new Route('GET', '/edition', UtilisateurController::class, 'edit'));
$collection->addRoute(new Route('POST', '/edition', UtilisateurController::class, 'edit'));
$router->addRoutes($collection);

// routes principales
$router->addRoute(new Route('GET', '/', HomeController::class, 'index'));
$router->addRoute(new Route('GET', '/accueil', HomeController::class, 'index'));
$router->addRoute(new Route('GET', '/connexion', UtilisateurController::class, 'logon'));
$router->addRoute(new Route('POST', '/connexion', UtilisateurController::class, 'logon'));
$router->addRoute(new Route('GET', '/inscription', UtilisateurController::class, 'signIn'));
$router->addRoute(new Route('POST', '/inscription', UtilisateurController::class, 'signIn'));
$router->addRoute(new Route('GET', '/deconnexion', UtilisateurController::class, 'logout'));

try {
    $router->match();
} catch(App\Exception\NotFoundException $e) {
    header("HTTP/1.0 404 Not Found");
    echo '<h2>'.$e->getTitle().'</h2>';
    echo '<p>'.$e->getMessage().'</p>';
    
    echo '<a href="/">Retourner à l\'accueil</a>';
} catch(Exception $e) {
    echo '<h2>Erreur</h2>';
    echo '<p>'.$e->getMessage().'</p>';

    echo '<a href="/">Retourner à l\'accueil</a>';
}