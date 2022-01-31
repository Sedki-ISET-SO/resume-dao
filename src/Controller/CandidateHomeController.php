<?php

namespace App\Controller;

use App\Entity\PDF;
use App\Form\PDFType;
use App\Entity\Resume;
use App\Entity\Listing;
use App\Form\ResumeType;
use App\Entity\ListingCategory;
use App\Repository\ResumeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Snappy\Pdf as KnpSnappyPdf;
// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

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
     * @Route("/candidate/resume", methods={"GET", "PUT"}, name="resume")
     */
    public function resume(ResumeRepository $repo, Request $req): Response
    {   
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        $lastId = $repo->getLastId();
        $resume = $repo->getSingleResume($lastId);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('listing/resume.html.twig', [
            "resume" => $resume
        ]);
        
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();
        
        // In this case, we want to write the file in the public directory
        $publicDirectory = $this->getParameter('kernel.project_dir') . '/public/resumes';
        // e.g /var/www/project/public/mypdf.pdf
        $filename='resume'.time().'_'.$lastId.'.pdf';

        $pdfFilepath =  $publicDirectory . '/' . $filename;
        
        $user = $this->getUser();
        $secondPath = $user->getSecondpath();
        if(strlen($secondPath) < 1) {
            $user->setPath('/resumes' . '/' . $filename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);

        return $this->render('listing/only.html.twig', [
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

            $user = $this->getUser();

            $user->setSecondpath('');

            $entityManager->persist($user);
        
            $entityManager->persist($resume);
            
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('listing/newListing.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/candidate/resume/update", name="resumeUpdate", methods={"GET","POST"})
     */
    public function update(Request $request, ResumeRepository $repo): Response
    {

        $lastId = $repo->getLastId();
        $resume = $repo->getSingleResume($lastId);

        $form = $this->createForm(ResumeType::class, $resume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
                
                // $startdate = $education->getStart();
                // $enddate = $education->getEnd();

                // if((strtotime($startdate)) > (strtotime($enddate)))
                // {
                //     $entityManager->remove($education);
                // }
            }

            $entityManager->persist($resume);

            $user = $this->getUser();

            $user->setSecondpath('');

            $entityManager->persist($user);

            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('listing/update.html.twig', [
            'resume' => $resume,
            'form' => $form->createView(),
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
            $user = $this->getUser();
            $entityManager = $this->getDoctrine()->getManager();

            foreach ($form->getData()->getFiles() as $pic) {
                $pdf->addFile($pic);
                $pic->setPDF($pdf);

                $entityManager->persist($pic);

                $filename = $pic->getName();
                $path = "/uploads/";
                $user->setPath('');
                $user->setSecondpath(strval($path.$filename));
                $entityManager->persist($user);
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