<?php

include '../vendor/autoload.php';

$manager = new App\Manager('blog_g4');

/** 
 * Génére du loremIpsum depuis une api
 */
function loremIpsum($quantite = 1, $type = 'paras', $lorem = false) {
    $url = "http://www.lipsum.com/feed/xml?amount=$quantite&what=$type&start=".($lorem?'yes':'no');
    return simplexml_load_file($url)->lipsum;
}

// Génére des données utilisateurs aléatoires
$request = file_get_contents('https://randomuser.me/api/?results=5&nat=fr');
$users = json_decode($request)->results;

// permet de dumper les contenus générés
$save = [];

// Création des users
foreach ($users as $user) {
    $password = $user->login->password;

    $utilisateur = new App\Entity\Utilisateur;
    $utilisateur->setLogin($user->login->username);
    $utilisateur->setPass($user->login->password);
    $utilisateur->setNom($user->name->last);
    $utilisateur->setPrenom($user->name->first);
    $utilisateur->setPhoto($user->picture->large);

    $save['users'][] = [
        'login' => $utilisateur->getLogin(),
        'pass' => $password
    ];

    $manager->nouveauUtilisateur($utilisateur);
}

$utilisateurs = $manager->findAll('Utilisateur');

// créé les articles et atribue un auteur aléatoire
$rand = rand(5, 20);
for ($i=0; $i < $rand; $i++) { 
    $auteur = array_rand($utilisateurs);
    $auteur = $utilisateurs[$auteur];

    $article = new App\Entity\Contenu;
    $article->setTitre(loremIpsum(rand(1, 10), 'words'))
            ->setCommentaire(loremIpsum(rand(1, 5), 'paras'))
            ->setPhoto('https://picsum.photos/600/300/?random')
            ->setAuteur($auteur);

    $save['articles'][] = $article;

    $manager->nouveauContenu($article);
}

var_dump($save);