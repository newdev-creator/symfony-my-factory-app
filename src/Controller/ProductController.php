<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'La production "' . $product->getName() . '" a bien été ajouter');

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/voir/{product}', name: 'show', methods: ['GET'], requirements: ['client' => '\d+'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/modifier/{product}', name: 'edit', methods: ['GET', 'POST'], requirements: ['client' => '\d+'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'La production "' . $product->getName() . '" a bien été modifié');

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{product}', name: 'delete', methods: ['POST'], requirements: ['client' => '\d+'])]
    public function delete(
        Request $request,
        Product $product,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('product_delete_' . $product->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
            $this->addFlash('success', 'La production "' . $product->getName() . '" a bien été supprimé');
        }

        return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/archiver/{product}', name: 'archive', methods: ['POST'], requirements: ['tent' => '\d+'])]
    public function archive(
        Request $request,
        Product $product,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('product_archive_' . $product->getId(), $request->request->get('_token'))) {
            $product->setIsArchived(1);
            $entityManager->flush();
            $this->addFlash('success', 'La production "' . $product->getName() . '" a bien été archivé');
        }

        return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/unarchived/{client}', name: 'unarchived', methods: ['POST'], requirements: ['tent' => '\d+'])]
    public function unarchived(
        Request $request,
        Product $product,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('client_unarchived_' . $product->getId(), $request->request->get('_token'))) {
            $product->setIsArchived(0);
            $entityManager->flush();
            $this->addFlash('success', 'La production "' . $product->getName() . '" a bien été sortie des archives');
        }

        return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    }
}
