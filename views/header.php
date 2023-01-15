<!DOCTYPE html>
<html>
<head>
    <title>Blog de Julien RAVIA</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="https://bootswatch.com/4/cosmo/bootstrap.css" crossorigin="anonymous">
    <style>
        .navbar {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/accueil">Blog de Julien RAVIA</a>

        <ul class="navbar-nav ml-auto">
            <?php if($session->get('login') === null): ?>
            <li class="nav-item">
                <a class="nav-link" href="/inscription">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/connexion">Connexion</a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="/profil?login=<?= $session->get('login') ?>">Mon profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/deconnexion">Déconnexion</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container">
