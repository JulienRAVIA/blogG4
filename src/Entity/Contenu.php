<?php

namespace App\Entity;

/**
 * Entité Contenu (correspondant à la table `contenu`), représentant un article
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
class Contenu
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $commentaire;

    /**
     * @var string
     */
    private $photo;

    /**
     * Retourne l'id de l'article
     * 
     * @return int
     */
    public function getId(): int
    {
        return (int) $this->id;
    }

    /**
     * Retourne le titre
     * 
     * @return string|null
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * Retourne la date sous forme d'objet DateTime
     * 
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return new \DateTime($this->date);
    }

    /**
     * @return string
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * Retourne le commentaire (contenu d'article)
     * 
     * @return string|null
     */
    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    /**
     * Attribue une date à partir d'un objet DateTime
     *
     * @param  \DateTime  $date
     *
     * @return  self
     */ 
    public function setDate(\DateTime $date): self
    {
        $this->date = $date->format('Y-m-d H:i:s');

        return $this;
    }

    /**
     * Affecte un commentaire (un contenu d'article)
     *
     * @param  string  $commentaire
     *
     * @return  self
     */ 
    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
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

    /**
     * Affecte un titre
     *
     * @param  string  $titre
     *
     * @return  self
     */ 
    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Retourne l'id de l'auteur de l'article
     *
     * @return  int
     */ 
    public function getAuteur(): int
    {
        return $this->auteur;
    }

    /**
     * Affecte un auteur à l'article à partir d'un objet de type Utilisateur
     *
     * @param  Utilisateur  $auteur
     *
     * @return  self
     */ 
    public function setAuteur(Utilisateur $auteur): self
    {
        $this->auteur = $auteur->getId();

        return $this;
    }

    /**
     * Affecte un auteur à l'article à partir de son identifiant
     *
     * @param  int $auteur
     *
     * @return  self
     */ 
    public function setIdAuteur(int $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }
}