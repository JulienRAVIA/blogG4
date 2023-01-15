<?= $renderer->render('header'); ?>

<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="titre">Titre de l'article</label>
                        <input type="text" id="titre" name="titre" class="form-control" value="<?= htmlspecialchars($article->getTitre()) ?>">
                    </div>
                    <div class="form-group">
                        <label for="commentaire">Commentaire</label>
                        <textarea id="commentaire" name="commentaire" class="form-control"><?= $article->getCommentaire() ?></textarea>
                    </div>
                    
                    <div class="btn-group" role="group">
                        <button type="reset" class="btn btn-light">Réinitialiser</button>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $renderer->render('footer'); ?>