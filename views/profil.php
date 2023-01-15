<?= $renderer->render('header'); ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <?php if(!is_null($messages)): ?>
                    <?php foreach($messages as $message): ?>
                        <div class="alert alert-<?= $message['type'] ?>"><?= $message['message'] ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <form action="" method="post" name="inscription">
                    <div class="form-group">
                        <label for="login">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="login" value="<?= htmlspecialchars($utilisateur->getLogin()) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="formulaire[nom]" value="<?= htmlspecialchars($utilisateur->getNom()) ?>">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="formulaire[prenom]" value="<?= htmlspecialchars($utilisateur->getPrenom()) ?>">
                    </div>

                    <div class="form-group">
                        <label for="pass">Ancien mot de passe</label>
                        <input type="password" class="form-control" id="pass" name="formulaire[old_pass]">
                    </div>
                    <div class="form-group">
                        <label for="pass">Mot de passe</label>
                        <input type="password" class="form-control" id="pass" name="formulaire[pass]">
                    </div>
                    <div class="form-group">
                        <label for="pass">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="pass" name="formulaire[pass_bis]">
                    </div>

                    <button class="btn btn-secondary" type="reset">Réinitialiser</button>
                    <button class="btn btn-primary" type="submit">Editer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $renderer->render('footer'); ?>