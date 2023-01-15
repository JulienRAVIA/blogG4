<?php

namespace App\Controller;

use Exception;
use App\FormManager;
use App\Entity\Contenu;
use App\Exception\NotFoundException;

/**
 * Controller des Articles (édition, création, suppression etc)
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
class ArticleController extends Controller
{
    /**
     * Affichage d'un article
     * 
     * @throws Exception si l'identifiant de l'article est vide ou non renseigné
     * @throws NotFoundException si l'article renseigné en paramètre n'existe pas
     *
     * @return void
     */
    public function show()
    {
        if(!isset($_GET['id']) || empty($_GET['id']))
            throw new Exception('Vous devez renseigner l\'identifiant de l\'article');
        
        $article = $this->manager->findOneById('Contenu', $_GET['id']);

        if(!$article)
            throw new NotFoundException('Article introuvable', 'Cet article semble ne pas exister, réessayez.');
            
        $auteur = $this->manager->findOneById('Utilisateur', $article->getAuteur());

        echo $this->renderer->render('article', compact('article', 'auteur'));
    }

    /**
     * Formulaire d'édition/création d'article
     *
     * @throws Exception si l'utilisateur qui essaye de modifier ou ajouter un article n'est pas connecté
     * @throws Exception si la personne qui essaye de modifier l'article n'est pas 'lauteur de celui ci
     * 
     * @return void
     */
    public function form(): void
    {
        if(!$this->session->get('id'))
            throw new Exception('Vous devez être connecté');

        if(isset($_GET['id']) && !empty($_GET['id'])) {
            $article = $this->manager->findOneById('Contenu', $_GET['id']);

            if($article->getAuteur() !== $this->session->get('id'))
                throw new Exception('Vous n\'êtes pas l\'auteur de cet article');
        }

        if(!isset($article) || $article === null)
            $article = new Contenu;

        echo $this->renderer->render('formulaire_article', compact('article'));
    }

    /**
     * Permet de gérer l'édition ET la création d'article
     *
     * @throws Exception si le formulaire n'est pas valide (champs requis non renseignés (ou pas correctement))
     * 
     * @return void
     */
    function handler(): void
    {
        $fields = [
            'titre' => array('required' => true, 'min' => 5, 'max' => 25),
            'commentaire' => array('required' => true,'min' => 1,'max' => 100000)
        ];

        $formManager = new FormManager($fields, $_POST);
        $result = $formManager->isValid();

        if($formManager->isValid()) {
            if(isset($_GET['id']))
            {
                if($this->update($_GET['id'], $_POST))
                    header('Location: /article?id='.$_GET['id']);
            } else {
                if($this->create($_POST))
                    header('Location: /article?id='.$this->manager->lastInsertId('Contenu'));
            }
        } else {
            throw new Exception('Le formulaire n\'est pas valide');
        }
    }

    /**
     * Met à jour l'article en BDD
     *
     * @param int $id
     * @param array $datas
     * 
     * @throws Exception si l'auteur de l'article 'nest pas le même que celui qui à essayé d'éditer l'article
     */
    public function update(int $id, array $datas)
    {
        $article = $this->manager->findOneById('Contenu', $id);

        if($article->getAuteur() != $this->session->get('id'))
            throw new Exception('Cet article ne vous appartient pas !');

        $article->setTitre($datas['titre'])
                ->setCommentaire($datas['commentaire']);

        return $this->manager->majContenu($article);
    }

    /**
     * Créé un article et l'insère en BDD
     *
     * @param array $datas
     */
    public function create(array $datas)
    {
        $article = new Contenu;
        $article->setTitre($datas['titre'])
                ->setCommentaire($datas['commentaire'])
                ->setPhoto('') // pas de photo par défaut, la flemme de gérer l'upload
                ->setDate(new \DateTime)
                ->setIdAuteur($this->session->get('id'));

        return $this->manager->nouveauContenu($article);
    }

    /**
     * Supprime un article de la BDD
     * 
     * @throws Exception si l'identifiant d'article est vide ou non renseigné
     * @throws NotFoundException si l'article n'existe pas en BDD
     * @throws Exception si la personne qui essaye de modifier l'article n'est pas l'auteur de celui ci
     *
     * @return void
     */
    public function delete()
    {
        if(!isset($_GET['id']) || empty($_GET['id']))
            throw new Exception('L\'identifiant de l\'article doit-être renseigné');
        
        $id = $_GET['id'];
        $article = $this->manager->findOneById('Contenu', $id);

        if(!$article)
            throw new NotFoundException('Cet article n\'existe pas');

        if($article->getAuteur() !== $this->session->get('id'))
            throw new Exception('Vous ne pouvez pas supprimer un article dont vous n\'êtes pas l\'auteur');
        
        $this->manager->deleteById('Contenu', $article->getId());
        header('Location: /accueil');
    }
}
