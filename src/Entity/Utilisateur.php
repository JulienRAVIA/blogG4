<?php

namespace App\Entity;

/**
 * Entité Utilisateur (correspondant à la table `utilisateur`), représentant un utilisateur
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
class Utilisateur
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $prenom;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $pass;

    /**
     * @var string
     */
    private $photo;

    /**
     * Retourne l'id
     *
     * @return  int
     */ 
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Retourne le nom
     *
     * @return  string
     */ 
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Affecte un nom
     *
     * @param  string  $nom
     *
     * @return  self
     */ 
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Retourne le login
     *
     * @return  string
     */ 
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * Affecte un login
     *
     * @param  string  $login
     *
     * @return  self
     */ 
    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Retourne le prénom
     *
     * @return  string
     */ 
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * Affecte un prénom
     *
     * @param  string  $prenom
     *
     * @return  self
     */ 
    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Retourne le mot de passe (hashé)
     *
     * @return  string
     */ 
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * Affecte et crypte un nouveau mot de passe
     *
     * @param  string  $pass
     *
     * @return  self
     */ 
    public function setPass(string $pass): self
    {
        $this->pass = password_hash($pass, PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * Retourne la dernière connexion
     *
     * @return  DateTime
     */ 
    public function getDerniereConnexion(): \DateTime
    {
        return new \DateTime($this->derniereConnexion);
    }

    /**
     * Retourne la photo
     *
     * @return  string
     */ 
    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * Affecte une photo
     *
     * @param  string  $photo
     *
     * @return  self
     */ 
    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
