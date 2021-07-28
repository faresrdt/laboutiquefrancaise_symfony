<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Adress;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/compte/adresses", name="account_adress")
     */
    public function index(): Response
    {
        return $this->render('account/adress.html.twig');
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="account_adress_add")
     */
    public function add(Cart $cart, Request $request): Response
    {
        $address = new Adress();
        $form = $this->createForm(AdressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());

            $this->entityManager->persist($address);
            $this->entityManager->flush();

            if ($cart->get()) {
                return $this->redirectToRoute('order');
            }

            return $this->redirectToRoute('account_adress');
        }

        return $this->render('account/adress_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="account_adress_edit")
     *
     * @param mixed $id
     */
    public function edit(Request $request, $id): Response
    {
        $address = $this->entityManager->getRepository(Adress::class)->findOneById($id);

        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_adress');
        }

        $form = $this->createForm(AdressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('account_adress');
        }

        return $this->render('account/adress_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="account_adress_delete")
     *
     * @param mixed $id
     */
    public function delete($id): Response
    {
        $address = $this->entityManager->getRepository(Adress::class)->findOneById($id);

        if ($address && $address->getUser() == $this->getUser()) {
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('account_adress');
    }
}