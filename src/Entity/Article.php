<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

// validation https://symfony.com/doc/current/validation.html
// On va renommer consrtraints en assert car c'est un langage de test unitaire
//https://symfony.com/doc/current/validation.html#constraint-configuration
use Symfony\Component\Validator\Constraints as Assert;

/**
 * je lui indique ou utiliser la Bdd
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Votre titre doit contenir {{ limit }} characteres minimum",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * 
     *  @Assert\Length(
     *      min = 2,
     *      minMessage = "Votre titre doit contenir {{ limit }} characteres minimum"
     * )
     * 
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
