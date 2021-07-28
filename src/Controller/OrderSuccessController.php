<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     *
     * @param mixed $stripeSessionId
     */
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if (0 == $order->getState()) {
            $cart->remove();

            $order->setState(1);
            $this->entityManager->flush();

            $mail = new Mail();
            $to_email = $order->getUser()->getEmail();
            $to_name = $order->getUser()->getFirstname();
            $subject = 'Merci pour votre Commande';
            $content = 'Bonjour '.$to_name.
                        'Votre commande est bien validée.';

            $mail->send($to_email, $to_name, $subject, $content);
        }

        return $this->render('order_success/index.html.twig', [
            'order' => $order,
        ]);
    }
}