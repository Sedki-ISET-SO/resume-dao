<?php

namespace App\Controller;

use App\Entity\ListingCategory;
use App\Form\ListingCategoryType;
use App\Form\RegistrationFormType;
use App\Repository\ListingCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class CategoryController extends AbstractController
{

    /**
     * @Route("/home/category/{id}", methods={"GET", "POST"}, name="single", requirements={"id"="\d+"})
     */
    public function single(int $id=1, ListingCategoryRepository $categoryRepository, Request $request): Response
    {
        $category = $categoryRepository->getSingleCategory($id);

        return $this->render('category/single.html.twig', [
            "category" => $category
        ]);
    }
    
    /**
     * @Route("/category/new", methods={"GET", "POST"}, name="newCategory")
     */
    public function new(Request $request): Response
    {
        $category = new ListingCategory();
        $form = $this->createForm(ListingCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('category/newCategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}