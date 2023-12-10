<?php

namespace App\Entity;

use App\Repository\DiningTableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiningTableRepository::class)]
class DiningTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column]
    private ?bool $isreserved = null;

    #[ORM\ManyToOne(inversedBy: 'diningTables')]
    private ?Restau $restau = null;

    #[ORM\OneToOne(mappedBy: 'DinningTable', cascade: ['persist', 'remove'])]
    private ?Reservation $reservations = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function isIsreserved(): ?bool
    {
        return $this->isreserved;
    }

    public function setIsreserved(bool $isreserved): static
    {
        $this->isreserved = $isreserved;

        return $this;
    }

    public function getRestau(): ?Restau
    {
        return $this->restau;
    }

    public function setRestau(?Restau $restau): static
    {
        $this->restau = $restau;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getReservations(): ?Reservation
    {
        return $this->reservations;
    }

    public function setReservations(?Reservation $reservations): static
    {
        // unset the owning side of the relation if necessary
        if ($reservations === null && $this->reservations !== null) {
            $this->reservations->setDinningTable(null);
        }

        // set the owning side of the relation if necessary
        if ($reservations !== null && $reservations->getDinningTable() !== $this) {
            $reservations->setDinningTable($this);
        }

        $this->reservations = $reservations;

        return $this;
    }
    public function __toString()
    {
        return $this->getId(); // Adjust to return an appropriate property
    }

}
