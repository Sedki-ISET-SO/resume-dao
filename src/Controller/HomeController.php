<?php

namespace App\Controller;

use App\Entity\Listing;
use App\Entity\ListingCategory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", methods={"GET"}, name="home")
     * @Route("/", methods={"GET"}, name="index")
     */
    public function showCategories(): Response
    {
        $categoryRepository = $this->getDoctrine()->getRepository(ListingCategory::class);
        $categories = $categoryRepository->getCategories();
        
        return $this->render('home/categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/home", methods={"GET"}, name="home")
     * @Route("/", methods={"GET"}, name="index")
     */
    public function showListings(): Response
    {
        $listingRepository = $this->getDoctrine()->getRepository(Listing::class);
        $listings = $listingRepository->getListings();
        
        return $this->render('home/index.html.twig', [
            'listings' => $listings,
        ]);
    }
}