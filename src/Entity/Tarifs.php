<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TarifsRepository")
 */
class Tarifs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_tarif;

    /**
     * @ORM\Column(type="integer")
     */
    private $tarif;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTypeTarif(): string
    {
        return $this->type_tarif;
    }

    public function setTypeTarif(string $type_tarif): self
    {
        $this->type_tarif = $type_tarif;

        return $this;
    }

    public function getTarif(): int
    {
        return $this->tarif;
    }

    public function setTarif(int $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }
}
