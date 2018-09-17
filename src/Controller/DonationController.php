<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Form\DonationType;
use App\Repository\DonationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DonationController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('donation/home.html.twig', [
            'title' => 'coucou',
        ]);
    }

    /**
     * @Route("/donation", name="donation_index", methods="GET")
     */
    public function index(DonationRepository $donationRepository): Response
    {
        return $this->render('donation/index.html.twig', ['donations' => $donationRepository->findAll()]);
    }

    /**
     * @Route("/donation/new", name="donation_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donation->setCreatedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($donation);
            $em->flush();

            return $this->redirectToRoute('donation_index');
        }

        return $this->render('donation/new.html.twig', [
            'donation' => $donation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/donation/{id}", name="donation_show", methods="GET")
     */
    public function show(Donation $donation): Response
    {
        return $this->render('donation/show.html.twig', ['donation' => $donation]);
    }

    /**
     * @Route("/donation/{id}/edit", name="donation_edit", methods="GET|POST")
     */
    public function edit(Request $request, Donation $donation): Response
    {
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donation_edit', ['id' => $donation->getId()]);
        }

        return $this->render('donation/edit.html.twig', [
            'donation' => $donation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/donation/{id}", name="donation_delete", methods="DELETE")
     */
    public function delete(Request $request, Donation $donation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$donation->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($donation);
            $em->flush();
        }

        return $this->redirectToRoute('donation_index');
    }
}
