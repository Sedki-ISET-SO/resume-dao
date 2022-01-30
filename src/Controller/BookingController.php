<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="booking")
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        $booking = $bookingRepository->findOneBy(['user' => $this->getUser(), 'status' => 'active']);

        return $this->render('booking/index.html.twig', [
            'booking' => $booking
        ]);
    }

    /**
     * @Route("/stripe/hook", name="stripe_hook")
     */
    public function stripeHook(Request $request)
    {
        $payload = $request->getContent();
        file_put_contents(__DIR__ . '/hook.json', $payload);
        return new Response('event hook');
    }

    /**
     * @Route("/stripe/create/session", name="stripe_create_session", methods={"POST"})
     */
    public function stripeCreateSession(BookingRepository $bookingRepository)
    {
        $booking = $bookingRepository->findOneBy(['user' => $this->getUser(), 'status' => 'active']);

        \Stripe\Stripe::setApiKey('sk_test_51KEJ74BVdOFdf8ljNiNA9P6KOD4GL1lXH3MHpOR6G8O6ZGfsRfj9p45HbikzDHrmRX6arrq49DouG4qRzoqUdEOp00jdMA595w');

        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $booking->getStripeLineItems(),
            'mode' => 'payment',
            'success_url' => $this->generateUrl('booking_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('booking_canceled', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return new JsonResponse(['id' => $checkout_session->id]);
    }

    /**
     * @Route("/booking/validation", name="booking_success")
     */
    public function bookingSuccess()
    {
        // return new Response('Done');
        return $this->render('booking/valid.html.twig');
    }

    /**
     * @Route("/booking/cancellation", name="booking_canceled")
     */
    public function bookingCancel()
    {
        return new Response('Canceled');
    }
}