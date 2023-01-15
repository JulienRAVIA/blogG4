<?= $renderer->render('header'); ?>

<div class="row justify-content-center">
    <div class="col-md-9">
        <?php if($utilisateur->getLogin() == $session->get('login')): ?>
            <a href="/profil/edition" class="btn btn-primary btn-block">Editer</a>
        <?php endif; ?>
        <div class="card mt-2">
            <div class="card-body">
                <h4>Profil de <?= htmlspecialchars($utilisateur->getLogin()) ?></h4>
            
                <?php if($utilisateur->getPhoto()): ?>
                    <img src="<?= $utilisateur->getPhoto() ?>" alt="Photo de <?= htmlspecialchars($utilisateur->getLogin()) ?>">
                <?php endif; ?>
                
                <ul class="list-unstyled mt-4">
                    <li>Dernière connexion le : <?= $utilisateur->getDerniereConnexion()->format('d/m/Y \à H:i:s'); ?></li>
                    <li>Identité : <?= strtoupper(htmlspecialchars($utilisateur->getNom())) .' '. ucfirst(htmlspecialchars($utilisateur->getPrenom())) ?></li>
                    <li></li>
                </ul>

                <h4>Ses articles (<?= count($articles) ?>) :</h4>
                <?php if(!empty($articles)): ?>
                <ul>
                    <?php foreach ($articles as $article): ?>
                        <li>
                            <a href="/article?id=<?= htmlspecialchars($article->getId()) ?>"><?= htmlspecialchars($article->getTitre()) ?></a> publié le
                            <?= $article->getDate()->format('d/m/Y \à H:i:s'); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                    <div class="alert alert-danger">Aucuns articles rédigés</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $renderer->render('footer'); ?>