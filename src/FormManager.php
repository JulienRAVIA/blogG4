<?php

namespace App;

/**
 * Classe de gestion d'un formulaire
 * (permet de vérifier les données d'un formulaire)
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
class FormManager
{
    /**
     * Champs et propriétés de champs
     *
     * @var array
     */
    private $fields;

    /**
     * Données du formulaire
     *
     * @var array
     */
    private $datas;

    /**
     * Constructeur
     *
     * @param array $fields
     * @param array $datas
     */
    public function __construct(array $fields, array $datas) 
    {
        $this->fields = $fields;
        $this->datas  = $datas;
    }

    /**
     * Permet de vérifier qu'un champ n'est pas du spam
     *
     * @param array $field
     * @param string $key
     *
     * @return bool Renvoie true si la longeur min et max de la valeur est inférieure à la longueur min et max attendue
     * si c'est un champ requis
     */
    public function fieldIsSpam(array $field, string $key): bool
    {
        extract($field);

        return (strlen($this->datas[$key]) <= $min) || (strlen($this->datas[$key]) >= $max);
    }

    /**
     * Permet de vérifier qu'un champ est correctement rempli si le champ est requis
     *
     * @param array $field
     * @param string $key
     *
     * @return bool Renvoie true si le champ est rempli correctement
     */
    public function fieldIsFilled(array $field, string $key): bool
    {
        return ($this->isset($this->datas[$key]) && !empty($this->datas[$key]));
    }

    /**
     * Vérifie si le champ est correctement rempli et n'est pas du spam
     *
     * @param array $field
     * @param string $key
     *
     * @return bool
     */
    public function fieldIsValid(array $field, string $key): bool
    {
        extract($field);

        if($required)
            return (!$this->fieldIsSpam($field, $key) || $this->fieldIsFilled($field, $key));
    
        return true;
    }

    /**
     * Traite tous les champs du formulaire et vérifie si le champ est correctement rempli
     * en fonction de ses propriétés
     *
     * @return bool Renvoie true si le formulaire est valide
     */
    public function isValid(): bool
    {
        foreach($this->fields as $index => $field)
        {
            if(!$this->fieldIsValid($field, $index))
                return false;
        }

        return true;
    }

    /**
     * Retourne la valeur d'un champ de formulaire
     *
     * @param string $key
     *
     * @return void
     */
    public function getValue(string $key)
    {
        return $this->datas[$key];
    }

    /**
     * Retourne si un champ est rempli
     *
     * @param string $key
     *
     * @return bool
     */
    public function isset(string $key): bool
    {
        return isset($this->datas[$key]);
    }
}
