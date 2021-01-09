<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide.")
     */
    private ?string $firstName;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide.")
     */
    private ?string $lastName;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide.")
     * @Assert\Email(message="L'email {{ value }} n'est pas valide")
     */
    private ?string $email;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide.")
     * @Assert\Length(min="25",minMessage="Votre message doit contenir au minimum {{ limit }} caractéres.")
     */
    private ?string $message;

    public function __construct()
    {
        $this->firstName = null;
        $this->lastName = null;
        $this->email = null;
        $this->message = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): Contact
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): Contact
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): Contact
    {
        $this->message = $message;
        return $this;
    }

}