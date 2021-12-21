<?php

namespace App\Controller;

use App\Entity\Issue;
use App\Form\IssuesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $issue = new Issue();
        $form = $this->createForm(IssuesType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $issue->setName($data['name']);
            $issue->setCountry($data['country']);
            $issue->setCity($data['city']);
            $issue->setMessage($data['message']);
            $issue->setAvailableAt($data['availableAt']);

            $entityManager->persist($issue);
            $entityManager->flush();

            $this->addFlash('message', 'Votre formulaire à bien été soumis 😊 !');
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
