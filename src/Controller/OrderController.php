<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/order', name: 'order_')]
class OrderController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($order);
            $entityManager->flush();

            $this->addFlash('success', 'La commande du client "' . $order->getClient() . '" a bien été ajouter');

            return $this->redirectToRoute('order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/voir/{order}', name: 'show', methods: ['GET'], requirements: ['client' => '\d+'])]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/modifier/{order}', name: 'edit', methods: ['GET', 'POST'], requirements: ['client' => '\d+'])]
    public function edit(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'La commande du client "' . $order->getClient() . '" a bien été modifié');

            return $this->redirectToRoute('order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{order}', name: 'delete', methods: ['POST'], requirements: ['client' => '\d+'])]
    public function delete(
        Request $request,
        Order $order,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('order_delete_' . $order->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();
            $this->addFlash('success', 'La commande du client "' . $order->getClient() . '" a bien été supprimé');
        }

        return $this->redirectToRoute('order_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/archiver/{order}', name: 'archive', methods: ['POST'], requirements: ['tent' => '\d+'])]
    public function archive(
        Request $request,
        Order $order,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('order_archive_' . $order->getId(), $request->request->get('_token'))) {
            $order->setIsArchived(1);
            $entityManager->flush();
            $this->addFlash('success', 'La commande du client "' . $order->getClient() . '" a bien été archivé');
        }

        return $this->redirectToRoute('order_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/unarchived/{client}', name: 'unarchived', methods: ['POST'], requirements: ['tent' => '\d+'])]
    public function unarchived(
        Request $request,
        Order $order,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('client_unarchived_' . $order->getId(), $request->request->get('_token'))) {
            $order->setIsArchived(0);
            $entityManager->flush();
            $this->addFlash('success', 'La commande du client "' . $order->getClient() . '" a bien été sortie des archives');
        }

        return $this->redirectToRoute('order_index', [], Response::HTTP_SEE_OTHER);
    }
}
