<?php

namespace App\Controller;

use Exception;
use App\FormManager;
use App\Entity\Utilisateur;
use App\Exception\NotFoundException;

/**
 * Controller des utilisateurs (affichage profil, inscription, connexion, édition)
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
class UtilisateurController extends Controller
{
    /**
     * Méthode de connexion
     *
     * @return void
     */
    public function logon(): void
    {
        // on vérifie que tous les champs soient renseignés
        if(isset($_POST['login'], $_POST['pass']) && (!empty($_POST['login']) && !empty($_POST['pass']))) {
            // on vérifie que l'utilisateur existe et on vérifie que le mot de passe renseigné corresponde au hashage enregistré en bdd
            $utilisateur = $this->manager->findOneBy('Utilisateur', 'login', $_POST['login']);
            if($utilisateur && password_verify($_POST['pass'], $utilisateur->getPass())) {
                $this->connect($utilisateur->getId(), $utilisateur->getLogin());

                header('Location: /accueil');
            } else {
                $message = [
                    'type' => 'danger',
                    'message' => 'L\'utilisateur n\'existe pas ou le mot de passe ne correspond pas'
                ];
            }
        } else {
            $message = [
                'type' => 'danger',
                'message' => 'Tous les champs ne sont pas remplis'
            ];
        }

        if($this->session->get('login'))
            header('Location: /accueil');

        echo $this->renderer->render('connexion', compact('message'));
    }

    /**
     * Création des identifiants de session
     *
     * @param int $id
     * @param string $login
     *
     * @return void
     */
    public function connect(int $id, string $login): void
    {
        $this->session->set('id', $id);
        $this->session->set('login', $login);
    }

    /**
     * Déconnexion
     *
     * @return void
     */
    public function logout(): void
    {
        $this->session->destroy();
        header('Location: /accueil');
    }

    /**
     * Affichage du profil d'un utilisateur
     *
     * @throws Exception Si le login est vide ou non renseigné
     * @throws NotFoundException Si l'utilisateur n'existe pas dans la BDD
     * 
     * @return void
     */
    public function show(): void
    {
        if(!isset($_GET['login']) || empty($_GET['login']))
            throw new Exception('Vous devez renseigner le login');
        
        $utilisateur = $this->manager->findOneBy('Utilisateur', 'login', $_GET['login']);

        if(!$utilisateur)
            throw new NotFoundException('Utilisateur inexistant', 'Cet utilisateur ne semble pas figurer dans la base de données');
        
        $articles = $this->manager->findBy('Contenu', 'auteur', $utilisateur->getId());

        echo $this->renderer->render('utilisateur', compact('utilisateur', 'articles'));
    }
    
    /**
     * Méthode d'inscription
     *
     * @return void
     */
    public function signIn(): void
    {
        $fields = [
            'login'  => array('required' => true, 'min' => 3, 'max' => 25),
            'nom'    => array('required' => true, 'min' => 2, 'max' => 25),
            'prenom' => array('required' => true, 'min' => 2, 'max' => 25),
            'pass'   => array('required' => true, 'min' => 5, 'max' => 100),
        ];

        $messages = null;
        
        if(isset($_POST['inscription'])) {
            $form = new FormManager($fields, $_POST['inscription']);

            // on vérifie que les champs soient bien renseignés
            if(!$form->isValid())
            $messages[] = [
                'type' => 'danger',
                'message' => 'Le formulaire est incorrect'
            ];
            
            // on vérifie que le mot de passe correspond à la confirmation
            if($form->getValue('pass') != $form->getValue('pass_bis'))
                $messages[] = [
                    'type' => 'danger',
                    'message' => 'Les deux mots de passe doivent être identiques'
                ];
            
            // on vérifie si l'utilisateur déjà, si c'est le cas on renvoie une erreur
            $utilisateur = $this->manager->findOneBy('Utilisateur', 'login', $form->getValue('login'));
            if($utilisateur)
                $messages[] = [
                    'type' => 'danger',
                    'message' => 'Cet utilisateur existe déjà'
                ];

            // on peut procéder à l'inscription si aucun message n'a été retourné
            if($messages === null) {
                $utilisateur = new Utilisateur();
                $utilisateur->setLogin(trim(htmlspecialchars($form->getValue('login'))));
                $utilisateur->setPass($form->getValue('pass'));
                $utilisateur->setNom($form->getValue('nom'));
                $utilisateur->setPrenom($form->getValue('prenom'));
                $utilisateur->setPhoto($form->getValue('login'));

                if($this->manager->nouveauUtilisateur($utilisateur))
                {
                    $this->connect($this->manager->lastInsertId('Utilisateur'), $utilisateur->getLogin());
                } else {
                    $messages[] = [
                        'type' => 'danger',
                        'message' => 'L\'inscription à échoué'
                    ];
                }
            }
        }

        // si l'utilisateur est déjà connecté, on le redirige
        if($this->session->get('login'))
            header('Location: /accueil');

        echo $this->renderer->render('inscription', compact('messages'));
    }

    /**
     * Edition du profil
     *
     * @throws Exception si l'utilisateur n'est pas connecté
     * 
     * @return void
     */
    public function edit(): void
    {
        $messages = null;
        $fields = [
            'nom'    => array('required' => true, 'min' => 2, 'max' => 25),
            'prenom' => array('required' => true, 'min' => 2, 'max' => 25),
        ];

        if(!$this->session->get('id'))
            throw new Exception('Vous devez être connecté !');

        $utilisateur = $this->manager->findOneById('Utilisateur', $this->session->get('id'));
        
        if(isset($_POST['formulaire'])) {
            $form = new FormManager($fields, $_POST['formulaire']);
            if(!$form->isValid())
                $messages[] = [
                    'type' => 'danger',
                    'message' => 'Le formulaire est incorrect'
                ];

            // Vérification des mots de passe renseigné (on vérifie si le mdp actuel est correct,
            // si le nouveau mdp correspond à la confirmation et si le nouveau mdp est différent du mot de passe actuel)
            if(!empty($form->getValue('pass')) || !empty($form->getValue('pass_bis')) || !empty($form->getValue('old_pass'))) {
                if($form->getValue('pass') != $form->getValue('pass_bis')) {
                    $messages[] = [
                        'type' => 'danger',
                        'message' => 'Les deux mots de passe doivent être identiques'
                    ];
                } elseif(empty($form->getValue('old_pass')) || !password_verify($form->getValue('old_pass'), $utilisateur->getPass())) {
                    $messages[] = [
                        'type' => 'danger',
                        'message' => 'Le mot de passe actuel est incorrect'
                    ]; 
                } elseif(password_verify($form->getValue('pass'), $utilisateur->getPass())) {
                        $messages[] = [
                            'type' => 'danger',
                            'message' => 'Le nouveau mot de passe ne doit pas être le même que celui actuel'
                        ];
                } else {
                    $utilisateur->setPass($form->getValue('pass'));
                }
            }

            // on peut procéder à l'édition du profil si aucun message n'a été retourné
            if($messages === null) {
                
                $utilisateur->setNom($form->getValue('nom'));
                $utilisateur->setPrenom($form->getValue('prenom'));

                if(!$this->manager->majUtilisateur($utilisateur))
                {
                    $messages[] = [
                        'type' => 'danger',
                        'message' => 'L\'édition à échoué'
                    ];
                } else {
                    $messages[] = [
                        'type' => 'success',
                        'message' => 'Profil modifié !'
                    ];
                }
            }
        }

        echo $this->renderer->render('profil', compact('utilisateur', 'messages'));
    }
}
