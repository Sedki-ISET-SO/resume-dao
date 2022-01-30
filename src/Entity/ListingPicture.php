<?php

namespace App\Entity;

use App\Repository\ListingPictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ListingPictureRepository::class)
 * @Vich\Uploadable
 */
class ListingPicture
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
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="name")
     * @var File
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=PDF::class, inversedBy="files")
     */
    private $pDF;

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

    public function getFile()
    {
        return $this->file;
    }

    public function setFile( $file)
    {
        $this->file = $file;

        return $this;
    }

    public function getPDF(): ?PDF
    {
        return $this->pDF;
    }

    public function setPDF(?PDF $pDF): self
    {
        $this->pDF = $pDF;

        return $this;
    }
}
