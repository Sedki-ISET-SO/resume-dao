<?php

namespace App\Entity;

use App\Entity\Listing;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\OneToMany(targetEntity=Listing::class, mappedBy="user", orphanRemoval=true)
     */
    private $listings;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="user")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="user")
     */
    private $bookings;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyname;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valid;

    /**
     * @ORM\OneToMany(targetEntity=PDF::class, mappedBy="candidate", orphanRemoval=true)
     */
    private $pDFs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phonenumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $secondpath;

    /**
     * @ORM\OneToMany(targetEntity=Resume::class, mappedBy="user")
     */
    private $resumes;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $saved = [];

    /**
     * @ORM\OneToMany(targetEntity=SavedResume::class, mappedBy="user")
     */
    private $saves;

    public function __construct()
    {
        $this->listings = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->pDFs = new ArrayCollection();
        $this->resumes = new ArrayCollection();
        $this->saves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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
            $listing->setUser($this);
        }

        return $this;
    }

    public function removeListing(Listing $listing): self
    {
        if ($this->listings->removeElement($listing)) {
            // set the owning side to null (unless already changed)
            if ($listing->getUser() === $this) {
                $listing->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
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
            $booking->setUser($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getUser() === $this) {
                $booking->setUser(null);
            }
        }

        return $this;
    }

    public function getCompanyname(): ?string
    {
        return $this->companyname;
    }

    public function setCompanyname(string $companyname): self
    {
        $this->companyname = $companyname;

        return $this;
    }

    public function getValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * @return Collection|PDF[]
     */
    public function getPDFs(): Collection
    {
        return $this->pDFs;
    }

    public function addPDF(PDF $pDF): self
    {
        if (!$this->pDFs->contains($pDF)) {
            $this->pDFs[] = $pDF;
            $pDF->setCandidate($this);
        }

        return $this;
    }

    public function removePDF(PDF $pDF): self
    {
        if ($this->pDFs->removeElement($pDF)) {
            // set the owning side to null (unless already changed)
            if ($pDF->getCandidate() === $this) {
                $pDF->setCandidate(null);
            }
        }

        return $this;
    }

    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    public function setPhonenumber(string $phonenumber): self
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getSecondpath(): ?string
    {
        return $this->secondpath;
    }

    public function setSecondpath(string $secondpath): self
    {
        $this->secondpath = $secondpath;

        return $this;
    }

    /**
     * @return Collection|Resume[]
     */
    public function getResumes(): Collection
    {
        return $this->resumes;
    }

    public function addResume(Resume $resume): self
    {
        if (!$this->resumes->contains($resume)) {
            $this->resumes[] = $resume;
            $resume->setUser($this);
        }

        return $this;
    }

    public function removeResume(Resume $resume): self
    {
        if ($this->resumes->removeElement($resume)) {
            // set the owning side to null (unless already changed)
            if ($resume->getUser() === $this) {
                $resume->setUser(null);
            }
        }

        return $this;
    }

    public function getSaved(): ?array
    {
        return $this->saved;
    }

    public function setSaved(?array $saved): self
    {
        $this->saved = $saved;

        return $this;
    }

    /**
     * @return Collection|SavedResume[]
     */
    public function getSaves(): Collection
    {
        return $this->saves;
    }

    public function addSave(SavedResume $save): self
    {
        if (!$this->saves->contains($save)) {
            $this->saves[] = $save;
            $save->setUser($this);
        }

        return $this;
    }

    public function removeSave(SavedResume $save): self
    {
        if ($this->saves->removeElement($save)) {
            // set the owning side to null (unless already changed)
            if ($save->getUser() === $this) {
                $save->setUser(null);
            }
        }

        return $this;
    }
}
