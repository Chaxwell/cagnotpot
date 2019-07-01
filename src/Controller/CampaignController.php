<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Form\CampaignType;
use App\Repository\CampaignRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CampaignController extends AbstractController
{
    /**
     * @Route("/", name="campaign_index", methods={"GET", "POST"})
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/campaigns", name="campaign_list", methods={"GET"})
     */
    public function list(Request $request, CampaignRepository $campaignRepository, PaginatorInterface $paginator): Response
    {
        $allCampaigns = $campaignRepository->findBy([], ['createdAt' => 'DESC']);
        $campaigns = $paginator->paginate(
            $allCampaigns,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('campaign/list.html.twig', [
            'campaigns' => $campaigns,
        ]);
    }

    /**
     * @Route("/new", name="campaign_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $campaign = new Campaign();
        $request->request->get('campaign_title') ? $campaign->setTitle($request->request->get('campaign_title')) : '';
        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campaign->setId()->setCreatedAt()->setUpdatedAt();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($campaign);
            $entityManager->flush();

            return $this->redirectToRoute('campaign_show', [
                'id' => $campaign->getId()
            ]);
        }

        return $this->render('campaign/new.html.twig', [
            'campaign' => $campaign,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="campaign_show", methods={"GET"})
     */
    public function show(Request $request, Campaign $campaign, CampaignRepository $campaignRepository, PaginatorInterface $paginator): Response
    {
        $numberOfParticipants = $campaignRepository->countParticipants($campaign);
        $totalAmount = $campaignRepository->countTotalAmount($campaign);
        $listOfParticipantInfos = $campaignRepository->getParticipants($campaign);
        $objectivePurcentage = (int) (round($totalAmount / $campaign->getGoal() * 100));

        $participants = $paginator->paginate(
            $listOfParticipantInfos,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('campaign/show.html.twig', [
            'campaign' => $campaign,
            'totalParticipants' => $numberOfParticipants,
            'totalAmount' => $totalAmount ? $totalAmount : '0',
            'objectivePurcentage' => $objectivePurcentage,
            'participants' => $participants,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="campaign_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Campaign $campaign, CampaignRepository $campaignRepository): Response
    {
        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);

        $numberOfParticipants = $campaignRepository->countParticipants($campaign);
        $totalAmount = $campaignRepository->countTotalAmount($campaign);
        $objectivePurcentage = (int) (round($totalAmount / $campaign->getGoal()) * 100);

        if ($form->isSubmitted() && $form->isValid()) {
            $campaign->setUpdatedAt();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($campaign);
            $entityManager->flush();

            return $this->redirectToRoute('campaign_show', [
                'id' => $campaign->getId(),
            ]);
        }

        return $this->render('campaign/edit.html.twig', [
            'campaign' => $campaign,
            'form' => $form->createView(),
            'objectivePurcentage' => $objectivePurcentage,
            'totalParticipants' => $numberOfParticipants,
            'totalAmount' => $totalAmount ? $totalAmount : '0',
        ]);
    }
}
