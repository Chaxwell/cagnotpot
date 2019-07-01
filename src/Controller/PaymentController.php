<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\Campaign;
use App\Form\PaymentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Participant;

/**
 * @Route("/payment")
 */
class PaymentController extends AbstractController
{
    /**
     * @Route("/{id}/new", name="payment_new", methods={"GET","POST"})
     */
    public function new(Request $request, Campaign $campaign): Response
    {
        $payment = new Payment();
        $request->request->get('amount') ? $payment->setAmount($request->request->get('amount')) : '';
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payment
                ->setCreatedAt()->setUpdatedAt()
                ->getParticipant()->setCampaign($campaign);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($payment);
            $entityManager->flush();

            return $this->redirectToRoute('campaign_show', [
                'id' => $campaign->getId(),
            ]);
        }

        return $this->render('payment/new.html.twig', [
            'payment' => $payment,
            'campaign' => $campaign,
            'form' => $form->createView(),
        ]);
    }
}
