<?php

namespace App\Controller;

use App\Entity\PDF;
use App\Form\PDFType;
use App\Entity\Resume;
use App\Entity\Listing;
use App\Form\ResumeType;
use App\Entity\SavedResume;
use App\Entity\ListingCategory;
use App\Repository\ResumeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_COMPANY")
 */
class CompanyController extends AbstractController
{
    

    /**
     * @Route("/company/save/{path}", name="save", requirements={"path"=".+"})
     */
    public function saveAction(string $path)
    {
        $saved = new SavedResume();

        $saved->SetPath($path);

        $saved->setUser($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($saved);
        $entityManager->flush();
    
        return new Response("The PDF file has been succesfully generated !".$path);
    }

    /**
     * @Route("/company/saved", methods={"GET"}, name="saved")
     */
    public function all(): Response
    {
        $repo = $this->getDoctrine()->getRepository(SavedResume::class);
        $paths = $repo->getSavedPaths();

        return $this->render('company/saved.html.twig', [
            "paths" => $paths
        ]);
    }
}