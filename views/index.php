<?= $renderer->render('header'); ?>

<div class="row">
    <div class="col-md-8">
        <h4>Les 15 derniers articles</h4>
        <div class="card">
            <div class="card-body">
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
    <div class="col-md-4">
        <h4>Les 15 derniers membres</h4>
        
        <div class="card mb-3">
            <div class="card-body">
                <?php if(!empty($utilisateurs)): ?>
                <ul>
                    <?php foreach ($utilisateurs as $utilisateur): ?>
                        <li>
                            <a href="/profil?login=<?= $utilisateur->getLogin() ?>"><?= $utilisateur->getLogin() ?></a> (<?= ucfirst($utilisateur->getPrenom()) . ' ' . strtoupper($utilisateur->getNom()) ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                    <div class="alert alert-danger">Aucuns membres enregistrés</div>
                <?php endif; ?>
            </div>
        </div>

        <?php if($session->get('login')): ?>
            <a href="/article/nouveau" class="btn btn-primary btn-lg btn-block">Ecrire un article</a>
            <a href="/profil/edition" class="btn btn-info btn-lg btn-block">Editer mon profil</a>
        <?php endif; ?>
    </div>
</div>

<?= $renderer->render('footer'); ?>