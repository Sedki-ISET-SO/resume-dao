<?php

namespace App\Entity;

use App\Repository\ListingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListingRepository::class)
 */
class Listing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $beds;

    /**
     * @ORM\Column(type="integer")
     */
    private $guests;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @ORM\Column(type="datetime")
     */
    private $published;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="listings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=ListingCategory::class, inversedBy="listings")
     */
    private $listingCategory;

    /**
     * @ORM\OneToMany(targetEntity=ListingAmenity::class, mappedBy="listing", orphanRemoval=true)
     */
    private $listingAmenities;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="listing", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $ratings;

    /**
     * @ORM\OneToMany(targetEntity=ListingAvailability::class, mappedBy="listing", orphanRemoval=true)
     */
    private $listingAvailabilities;

    /**
     * @ORM\ManyToMany(targetEntity=Booking::class, mappedBy="listings", orphanRemoval=true)
     */
    private $bookings;

    public function __construct()
    {
        $this->listingAmenities = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->listingAvailabilities = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBeds(): ?int
    {
        return $this->beds;
    }

    public function setBeds(int $beds): self
    {
        $this->beds = $beds;

        return $this;
    }

    public function getGuests(): ?int
    {
        return $this->guests;
    }

    public function setGuests(int $guests): self
    {
        $this->guests = $guests;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(\DateTimeInterface $published): self
    {
        $this->published = $published;

        return $this;
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

    public function getListingCategory(): ?ListingCategory
    {
        return $this->listingCategory;
    }

    public function setListingCategory(?ListingCategory $listingCategory): self
    {
        $this->listingCategory = $listingCategory;

        return $this;
    }

    /**
     * @return Collection|ListingAmenity[]
     */
    public function getListingAmenities(): Collection
    {
        return $this->listingAmenities;
    }

    public function addListingAmenity(ListingAmenity $listingAmenity): self
    {
        if (!$this->listingAmenities->contains($listingAmenity)) {
            $this->listingAmenities[] = $listingAmenity;
            $listingAmenity->setListing($this);
        }

        return $this;
    }

    public function removeListingAmenity(ListingAmenity $listingAmenity): self
    {
        if ($this->listingAmenities->removeElement($listingAmenity)) {
            // set the owning side to null (unless already changed)
            if ($listingAmenity->getListing() === $this) {
                $listingAmenity->setListing(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setListing($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getListing() === $this) {
                $rating->setListing(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ListingAvailability[]
     */
    public function getListingAvailabilities(): Collection
    {
        return $this->listingAvailabilities;
    }

    public function addListingAvailability(ListingAvailability $listingAvailability): self
    {
        if (!$this->listingAvailabilities->contains($listingAvailability)) {
            $this->listingAvailabilities[] = $listingAvailability;
            $listingAvailability->setListing($this);
        }

        return $this;
    }

    public function removeListingAvailability(ListingAvailability $listingAvailability): self
    {
        if ($this->listingAvailabilities->removeElement($listingAvailability)) {
            // set the owning side to null (unless already changed)
            if ($listingAvailability->getListing() === $this) {
                $listingAvailability->setListing(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
    return (string) $this->listingCategory;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->addListing($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            $booking->removeListing($this);
        }

        return $this;
    }
}
