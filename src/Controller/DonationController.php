<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DonationController extends AbstractController
{
    /**
     * @Route("/donation", name="donation")
     */
    public function index()
    {
        return $this->render('donation/index.html.twig', [
            'controller_name' => 'DonationController',
        ]);
    }
}
