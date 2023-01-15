<?php

namespace App;

use \PDO;
use App\Entity\{ Contenu, Utilisateur };

/**
 * Classe de gestion de base de données (requêtes)
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
class Manager
{
    /**
     * Hôte de la base de données
     * 
     * @var string 
     */
    private $hote;

    /**
     * Nom de la base de données
     * 
     * @var string 
     */
    private $nom;

    /**
     * Nom d'utilisateur pour la base de données
     * 
     * @var string 
     */
    private $utilisateur;

    /**
     * Mot de passe
     * 
     * @var string 
     */
    private $mdp;

    /**
     * Instance PDO
     * 
     * @var PDO 
     */
    private $instance;

    /**
     * Constructeur
     *
     * @param string $nom
     * @param string $hote
     * @param string $utilisateur
     * @param string $mdp
     */
    public function __construct(string $nom, string $hote = 'localhost', string $utilisateur = 'root', string $mdp = '')
    {
        $this->hote          =   $hote;
        $this->nom           =   $nom;
        $this->utilisateur   =   $utilisateur;
        $this->mdp           =   $mdp;

        $this->instance = new PDO('mysql:dbname='.$this->nom.';host='.$this->hote, $this->utilisateur, $this->mdp, [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ]);
    }

    /**
     * Retourne l'instance PDO
     *
     * @return PDO
     */
    public function getInstance(): PDO
    {
        return $this->getInstance();
    }

    /**
     * Méthode de surcharge pour récuperer le dernier identifiant inséré dans la BDD
     *
     * @param string|null $name
     *
     * @return void
     */
    public function lastInsertId(?string $name = null)
    {
        if($name !== null)
            $name = strtolower($name);

        return $this->instance->lastInsertId($name);
    }

    /**
     * Méthode magique pour récupérer une ou plusieurs entités correspondant à une classe
     *
     * @param string $class
     * @param int $id
     *
     * @return void
     */
    public function findAll(string $class) 
    {
        $table = strtolower($class);
        $req = $this->instance->query("SELECT * FROM {$table}");
        
        return $req->fetchAll(PDO::FETCH_CLASS, 'App\Entity\\'.$class);
    }

    /**
     * Méthode magique pour récupérer une ou plusieurs entités correspondant à une classe
     * ou l'id correspondant à l'id passé en paramètre
     *
     * @param string $class
     * @param int $id
     *
     * @return void
     */
    public function findById(string $class, int $id) 
    {
        $table = strtolower($class);
        $req = $this->instance->prepare("SELECT * FROM {$table} WHERE id = :id");
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $req->fetchAll(PDO::FETCH_CLASS, 'App\Entity\\'.$class);
    }
    
    /**
     * Méthode magique pour récupérer une entité correspondant à une classe
     * ou l'id correspondant à l'id passé en paramètre
     *
     * @param string $class
     * @param int $id
     *
     * @return void
     */
    public function findOneById(string $class, int $id) 
    {
        $table = strtolower($class);
        $req = $this->instance->prepare('SELECT * FROM '.$table.' WHERE id = :id');
        $req->execute(compact('id'));
        $req->setFetchMode(PDO::FETCH_CLASS, 'App\Entity\\'.$class);

        return $req->fetch();
    }

    /**
     * Méthode magique pour récupérer une ou plusieurs entités correspondant à une classe
     * en faisant une clause WHERE sur un paramètre choisi
     *
     * @param string $class
     * @param string $field
     * @param $value
     *
     * @return void
     */
    public function findBy(string $class, string $field, $value) 
    {
        $table = strtolower($class);
        $req = $this->instance->prepare('SELECT * FROM '.$table.' WHERE '.$field.' = :value');
        $req->execute(compact('value'));
        $req->setFetchMode(PDO::FETCH_CLASS, 'App\Entity\\'.$class);

        return $req->fetchAll();
    }

    /**
     * Méthode magique pour récupérer une entité correspondant à une classe
     * en faisant une clause WHERE sur un paramètre choisi
     *
     * @param string $class
     * @param string $field
     * @param $value
     *
     * @return void
     */
    public function findOneBy(string $class, string $field, $value) 
    {
        $table = strtolower($class);
        $req = $this->instance->prepare('SELECT * FROM '.$table.' WHERE '.$field.' = :value');
        $req->execute(compact('value'));
        $req->setFetchMode(PDO::FETCH_CLASS, 'App\Entity\\'.$class);
        
        return $req->fetch();
    }
    
    /**
     * Supprime une donnée de la BDD
     *
     * @param string $class
     *
     * @return bool
     */
    public function deleteById(string $class, int $id)
    {
        $table = strtolower($class);
        $req = $this->instance->prepare('DELETE FROM '.$table.' WHERE id = :id');
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $req->execute();
    }
    
    /**
     * Insère un article dans la BDD
     *
     * @param Contenu $contenu
     *
     * @return bool
     */
    public function nouveauContenu(Contenu $contenu)
    {
        $req = $this->instance->prepare('INSERT INTO contenu(titre, commentaire, photo, auteur, date) VALUES(:titre, :commentaire, :photo, :auteur, :date)');
        $req->bindValue(':titre', $contenu->getTitre());
        $req->bindValue(':commentaire', $contenu->getCommentaire());
        $req->bindValue(':photo', $contenu->getPhoto());
        $req->bindValue(':auteur', $contenu->getAuteur());
        $req->bindValue(':date', $contenu->getDate()->format('Y-m-d H:i:s'));
        
        return $req->execute();
    }

    /**
     * Met à jour un article
     *
     * @param Contenu $contenu
     *
     * @return bool
     */
    public function majContenu(Contenu $contenu)
    {
        $req = $this->instance->prepare('UPDATE contenu SET titre = :titre, commentaire = :commentaire, date = :date, photo = :photo WHERE id = :id');
        $req->bindValue(':id', $contenu->getId(), PDO::PARAM_INT);
        $req->bindValue(':titre', $contenu->getTitre());
        $req->bindValue(':commentaire', $contenu->getCommentaire());
        $req->bindValue(':photo', $contenu->getPhoto());
        $req->bindValue(':date', $contenu->getDate()->format('Y-m-d H:i:s'));
        
        return $req->execute();
    }

    /**
     * Insère un utilisateur dans la BDD
     *
     * @param Utilisateur $utilisateur
     *
     * @return bool
     */
    public function nouveauUtilisateur(Utilisateur $utilisateur)
    {
        $req = $this->instance->prepare('INSERT INTO utilisateur(nom, prenom, login, pass, photo) VALUES(:nom, :prenom, :login, :pass, :photo)');
        $req->bindValue(':nom', $utilisateur->getNom(), PDO::PARAM_STR);
        $req->bindValue(':prenom', $utilisateur->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':login', $utilisateur->getLogin(), PDO::PARAM_STR);
        $req->bindValue(':pass', $utilisateur->getPass(), PDO::PARAM_STR);
        $req->bindValue(':photo', $utilisateur->getPhoto(), PDO::PARAM_STR);
        
        return $req->execute();
    }

    /**
     * Met à jour les informations d'un utilisateur
     *
     * @param Utilisateur $utilisateur
     *
     * @return bool
     */
    public function majUtilisateur(Utilisateur $utilisateur)
    {
        $req = $this->instance->prepare('UPDATE utilisateur SET nom = :nom, prenom = :prenom, login = :login, pass = :pass, photo = :photo WHERE id = :id');
        $req->bindValue(':id', $utilisateur->getId(), PDO::PARAM_INT);
        $req->bindValue(':nom', $utilisateur->getNom(), PDO::PARAM_STR);
        $req->bindValue(':prenom', $utilisateur->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':login', $utilisateur->getLogin(), PDO::PARAM_STR);
        $req->bindValue(':pass', $utilisateur->getPass(), PDO::PARAM_STR);
        $req->bindValue(':photo', $utilisateur->getPhoto(), PDO::PARAM_STR);
        
        return $req->execute();
    }
}
