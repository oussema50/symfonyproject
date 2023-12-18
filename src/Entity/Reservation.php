<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'reservation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: DiningTable::class)]
    private Collection $diningTables;
    //cascade: ['persist', 'remove']
    #[ORM\OneToOne(inversedBy: 'reservations')]
    private ?DiningTable $DinningTable = null;

    #[ORM\Column]
    private ?int $restauId = null;

    public function __construct()
    {
        $this->diningTables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, DiningTable>
     */
    public function getDiningTables(): Collection
    {
        return $this->diningTables;
    }

    public function addDiningTable(DiningTable $diningTable): static
    {
        if (!$this->diningTables->contains($diningTable)) {
            $this->diningTables->add($diningTable);
            $diningTable->setReservation($this);
        }

        return $this;
    }

    public function removeDiningTable(DiningTable $diningTable): static
    {
        if ($this->diningTables->removeElement($diningTable)) {
            // set the owning side to null (unless already changed)
            if ($diningTable->getReservation() === $this) {
                $diningTable->setReservation(null);
            }
        }

        return $this;
    }

    public function getDinningTable(): ?DiningTable
    {
        return $this->DinningTable;
    }

    public function setDinningTable(?DiningTable $DinningTable): static
    {
        $this->DinningTable = $DinningTable;

        return $this;
    }

    public function getRestauId(): ?int
    {
        return $this->restauId;
    }

    public function setRestauId(int $restauId): static
    {
        $this->restauId = $restauId;

        return $this;
    }
}
