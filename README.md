## TP Blog PHP

- Auteur : [Julien RAVIA](https://julienravia.fr)
- Contexte: TP PHP G4

### Détails

- Architecture MVC Maison (vues dans `/views`, controllers dans `src/Controller/` et partie modèle dans `src/Manager.php` et `src/Entity`)
- Mini ORM maison (classe Manager + namespace Entity)
    - le manager va retourner des instances d'entités et les hydrater automatiquement, pratique pour fonctionner avec uniquement de l'objet
    - le manager va attendre dans la plupart des cas des entités pour l'insertion, la suppression et/ou la modification en base de données (selon ce qu'on à besoin de faire)
- Mini Routeur basique maison (namespace Router)
- Mini moteur de template (Renderer) "maison" (50%) 
- Gestionnaire de session (SessionManager) maison
- Gestionnaire de formulaire (FormManager) maison (mais mal foutu) 

En bref, tout est homemade mis à part l'autoloader : merci [Composer](https://getcomposer.org) (dossier `vendor`)

### Test

Pour générer des données de test :

executer fixtures.php une fois configuré (bien paramètrer l'instance de Manager avec les paramètres qui pourraient manquer/changer)
Et voilà, utilisateurs bidons et articles bidons !