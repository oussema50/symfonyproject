<?php

namespace App\Entity;

use App\Repository\RestauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestauRepository::class)]
class Restau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $log = null;

    #[ORM\Column(length: 50)]
    private ?string $lat = null;

    #[ORM\OneToMany(mappedBy: 'restau', targetEntity: Menu::class)]
    private Collection $menus;

    #[ORM\ManyToOne(inversedBy: 'restau')]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'restau', targetEntity: DiningTable::class)]
    private Collection $diningTables;
  

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->diningTables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLog(): ?string
    {
        return $this->log;
    }

    public function setLog(string $log): static
    {
        $this->log = $log;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): static
    {
        if (!$this->menus->contains($menu)) {
            $this->menus->add($menu);
            $menu->setRestau($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): static
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getRestau() === $this) {
                $menu->setRestau(null);
            }
        }

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
            $diningTable->setRestau($this);
        }

        return $this;
    }

    public function removeDiningTable(DiningTable $diningTable): static
    {
        if ($this->diningTables->removeElement($diningTable)) {
            // set the owning side to null (unless already changed)
            if ($diningTable->getRestau() === $this) {
                $diningTable->setRestau(null);
            }
        }

        return $this;
    }


}
