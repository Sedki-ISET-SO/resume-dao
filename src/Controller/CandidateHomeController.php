<?php

namespace App\Controller;

use App\Entity\PDF;
use App\Form\PDFType;
use App\Entity\Resume;
use App\Entity\Listing;
use App\Form\ResumeType;
use App\Entity\ListingCategory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_CANDIDATE")
 */
class CandidateHomeController extends AbstractController
{
    
    /**
     * @Route("/candidate/home", methods={"GET"}, name="home")
     * @Route("/", methods={"GET"}, name="index")
     */
    public function showResumes(): Response
    {
        $listingRepository = $this->getDoctrine()->getRepository(Listing::class);
        $listings = $listingRepository->getListings();
        
        return $this->render('home/index.html.twig', [
            'listings' => $listings,
        ]);
    }

    /**
     * @Route("/candidate/resume/{id}", methods={"GET", "POST"}, name="single", requirements={"id"="\d+"})
     */
    public function single(int $id=1, Listingrepository $listingRepository, Request $request): Response
    {
        $listing = $listingRepository->getSingleListing($id);

        return $this->render('listing/single.html.twig', [
            "listing" => $listing
        ]);
    }
    
    /**
     * @Route("/home/rules", methods={"GET"}, name="rules")
     */
    public function rules(): Response
    {
        return $this->render('home/rules.html.twig', [
        ]);
    }

    /**
     * @Route("/candidate/resume/generate", methods={"GET", "POST"}, name="newResume")
     */
    public function newListing(Request $request): Response
    {
        $resume = new Resume();
        

        $form = $this->createForm(ResumeType::class, $resume);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $resume->setPublished(new \DateTime());
            $resume->setUser($this->getUser());
            
            $entityManager = $this->getDoctrine()->getManager();

            $skills = $form->get('skills')->getData();
            foreach ($skills as $skill) {
                $resume->addSkill($skill);
                $skill->setResume($resume);
                $entityManager->persist($skill);
            }

            $workExperiences = $form->get('workExperiences')->getData();
            foreach ($workExperiences as $workExperience) {
                $resume->addWorkExperience($workExperience);
                $workExperience->setResume($resume);
                $entityManager->persist($workExperience);
            }

            $educations = $form->get('educations')->getData();
            foreach ($educations as $education) {
                $resume->addEducation($education);
                $education->setResume($resume);
                $entityManager->persist($education);
            }
            // foreach ($form->getData()->getListingPictures() as $pic) {
            //     $listing->addPicture($pic);
            //     $pic->setListing($listing);
            //     $entityManager->persist($pic);
            // }

            $entityManager->persist($resume);
            
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('listing/newListing.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/candidate/resume/upload", methods={"GET", "POST"}, name="uploadResumeFile")
     */
    public function uploadResumeFile(Request $request): Response
    {
        $pdf = new PDF();
        
        $form = $this->createForm(PDFType::class, $pdf);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $pdf->setCandidate($this->getUser());
            
            $entityManager = $this->getDoctrine()->getManager();

            foreach ($form->getData()->getFiles() as $pic) {
                $pdf->addFile($pic);
                $pic->setPDF($pdf);
                $entityManager->persist($pic);
            }

            $entityManager->persist($pdf);
            
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('listing/uploadResume.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/candidates/resumes", methods={"GET"}, name="userListings")
     */
    public function userListings(): Response
    {
        $listings = $this->getUser()->getListings();

        return $this->render('home/index.html.twig', [
            "listings" => $listings
        ]);
    }

    /**
     * @Route("/user/profil", methods={"GET", "POST"}, name="userProfil")
     */
    public function userProfil(): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(RegistrationFormType::class, $user);

        return $this->render('home/userProfil.html.twig', [
            "form" => $form->createView()
        ]);
    }
}