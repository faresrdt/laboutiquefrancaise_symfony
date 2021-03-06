<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/mot-de-passe-oublie", name="reset_password")
     */
    public function index(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($request->get('email')) {
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            if ($user) {
                // Étape 1 : enregistrer la demande de reset password avec user, token, createdAt
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new DateTime());
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                //Étape 2 : envoyer un mail à l'utilisateur avec un lien lui permettant de mettre à jour son mot de passe
                $mail = new Mail();
                $url = $this->generateUrl('update_password', [
                    'token' => $reset_password->getToken(),
                ]);
                $to_mail = $user->getEmail();
                $to_name = $user->getFirstname().' '.$user->getLastname();
                $subject = 'Réinitialiser votre mot de passe sur La Boutique Française.';
                $content = 'Bonjour '.$to_name."<br>
                Vous avez demandé à réinitialiser votre mot de passe sur le site La Boutique Française.<br><br>
                Merci de bien vouloir cliquer sur le lien suivant pour <a href='".$url."'>mettre à jour votre mot de passe.</a>
                ";

                $mail->send($to_mail, $to_name, $subject, $content);
                $this->addFlash('notice', "Un mail va vous être envoyé pour réinitialiser votre mot de passe. Veuillez vérifier dans les spams si vous ne le recevez pas d'ici quelques minutes.");
            } else {
                $this->addFlash('notice', "Aucun compte n'existe avec cette adresse e-mail.");
            }
        }

        return $this->render('reset_password/index.html.twig');
    }

    /**
     * @Route("/modifier-mot-de-passe/{token}", name="update_password")
     *
     * @param mixed $token
     */
    public function update(Request $request, $token, UserPasswordEncoderInterface $encoder)
    {
        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);

        if (!$reset_password) {
            $this->redirectToRoute('reset_password');
        } else {
            $now = new DateTime();
            if ($now > $reset_password->getCreatedAt()->modify('+ 3 hour')) {
                $this->addFlash('notice', 'Votre demande de mot de passe a expirée. Merci de la renouveler.');

                return $this->redirectToRoute('reset_password');
            }

            //Rendre une vue avec mot de passe et confirmer mot de passe
            $form = $this->createForm(ResetPasswordType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $new_pwd = $form->get('new_password')->getData();

                // Encodage du mot de passe
                $password = $encoder->encodePassword($reset_password->getUser(), $new_pwd);
                $reset_password->getUser()->setPassword($password);

                // flush en BDD
                $this->entityManager->flush();

                // Redirection de l'utilisateur vers la page connexion
                $this->addFlash('notice', 'Votre mot de passe à bien été mis à jour.');

                return $this->redirectToRoute('app_login');
            }

            return $this->render('reset_password/update.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}