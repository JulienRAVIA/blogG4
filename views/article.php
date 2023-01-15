<?= $renderer->render('header'); ?>

<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card mb-2">
            <div class="card-body">
                <h2 class="text-center mb-2"><?= htmlspecialchars($article->getTitre()) ?></h2>

                <?php if($article->getPhoto()): ?>
                    <center>
                        <img src="<?= $article->getPhoto() ?>" alt="Photo de l'article <?= htmlspecialchars($article->getTitre()) ?>">
                    </center>
                <?php endif; ?>

                <p class="mt-4">
                    <?= htmlspecialchars($article->getCommentaire()) ?>
                </p>

                <div class="float-right">Publié par <a href="/profil?login=<?= htmlspecialchars($auteur->getLogin()) ?>"><?= htmlspecialchars($auteur->getLogin()) ?></a> le <?= $article->getDate()->format('d/m/Y \à H:i:s'); ?></div>
            </div>
        </div>
        <?php if((int) $session->get('id') == $article->getAuteur()): ?>
            <a href="/article/edition?id=<?= $article->getId() ?>" class="btn btn-primary btn-sm">Editer</a>
            <a href="/article/suppression?id=<?= $article->getId() ?>" class="btn btn-danger btn-sm">Supprimer</a>
        <?php endif; ?>
    </div>
</div>

<?= $renderer->render('footer'); ?>