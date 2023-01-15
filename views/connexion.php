<?= $renderer->render('header'); ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <?php if(!is_null($message)): ?>
                    <div class="alert alert-<?= $message['type'] ?>"><?= $message['message'] ?></div>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="login">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="login" name="login">
                    </div>
                    <div class="form-group">
                        <label for="pass">Mot de passe</label>
                        <input type="password" class="form-control" id="pass" name="pass">
                    </div>

                    <button class="btn btn-primary" type="submit" name="submit">Connexion</button>
                    <button class="btn btn-secondary" type="reset">Réinitialiser</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $renderer->render('footer'); ?>