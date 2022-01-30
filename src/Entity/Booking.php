<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Listing::class, inversedBy="bookings")
     */
    private $listings;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     */
    private $bookedFrom;

    /**
     * @ORM\Column(type="date")
     */
    private $bookedUntil;

    public function __construct()
    {
        $this->listings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Listing[]
     */
    public function getListings(): Collection
    {
        return $this->listings;
    }

    public function addListing(Listing $listing): self
    {
        if (!$this->listings->contains($listing)) {
            $this->listings[] = $listing;
        }

        return $this;
    }

    public function removeListing(Listing $listing): self
    {
        $this->listings->removeElement($listing);

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBookedFrom(): ?\DateTimeInterface
    {
        return $this->bookedFrom;
    }

    public function setBookedFrom(\DateTimeInterface $bookedFrom): self
    {
        $this->bookedFrom = $bookedFrom;

        return $this;
    }

    public function getBookedUntil(): ?\DateTimeInterface
    {
        return $this->bookedUntil;
    }

    public function setBookedUntil(\DateTimeInterface $bookedUntil): self
    {
        $this->bookedUntil = $bookedUntil;

        return $this;
    }

    public function getTotal(): int
    {
        $total = 0;

        $abs_diff = $this->getBookedUntil()->diff($this->getBookedFrom())->format("%a");
        
        foreach($this->getListings() as $savedListing){
            $total += ($savedListing->getPrice() * $abs_diff);
        }
        return $total;
    }

    public function getStripeLineItems()
    {
        $lineItems = [];

        $abs_diff = $this->getBookedUntil()->diff($this->getBookedFrom())->format("%a");

        foreach($this->getListings() as $savedListing){

            $line = [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => ($savedListing->getPrice() * $abs_diff),
                        'product_data' => [
                            'name' => $savedListing->getName(),
                        ],
                    ],
                    'quantity' => 1,
                ];

            $lineItems[] = $line;
        }

        return $lineItems;
    }
}
