<?php

namespace App\Entity;

use App\Repository\PDFRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PDFRepository::class)
 */
class PDF
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=ListingPicture::class, mappedBy="pDF")
     */
    private $files;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pDFs")
     */
    private $candidate;

    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|ListingPicture[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(ListingPicture $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setPDF($this);
        }

        return $this;
    }

    public function removeFile(ListingPicture $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getPDF() === $this) {
                $file->setPDF(null);
            }
        }

        return $this;
    }

    public function getCandidate(): ?User
    {
        return $this->candidate;
    }

    public function setCandidate(?User $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }
}
