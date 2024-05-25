<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/client', name: 'client_')]
class ClientController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($client);
            $entityManager->flush();

            $this->addFlash('success', 'Le client "' . $client->getFactory() . '" a bien été ajouter');

            return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/voir/{client}', name: 'show', methods: ['GET'], requirements: ['client' => '\d+'])]
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('modifier/{client}', name: 'edit', methods: ['GET', 'POST'], requirements: ['client' => '\d+'])]
    public function edit(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le client "' . $client->getFactory() . '" a bien été modifier');

            return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('supprimer/{client}', name: 'delete', methods: ['POST'], requirements: ['client' => '\d+'])]
    public function delete(
        Request $request,
        Client $client,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('client_delete_' . $client->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
            $this->addFlash('success', 'Le client "' . $client->getFactory() . '" a bien été supprimer');
        }

        return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
    }
}
