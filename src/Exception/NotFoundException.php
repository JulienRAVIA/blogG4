<?php

namespace App\Exception;

/**
 * Cette exception permet de catcher plus facilement les routes non inexistantes
 * 
 * @author Julien RAVIA <julien.ravia@gmail.com>
 */
class NotFoundException extends \Exception
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $message;

    /**
     * Constructeur
     *
     * @param string $title
     * @param string $message
     */
    public function __construct(string $title, string $message) 
    {
        $this->title = $title;
        parent::__construct($message, 404);
    }

    /**
     * Retourne le titre de l'exception
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
