<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class SignupController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @Route(path="/signup",name="signup_app")
     */
    public function user(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $isOk = false;
        /** @var User $user */
        $user = new User();
        $newUserForm = $this->createForm(UserType::class, $user);
        $newUserForm->handleRequest($request);
        if ($newUserForm->isSubmitted() && $newUserForm->isValid()) {
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $newUserForm->get('password')->getData()
                )
            );
            $em = $this->getDoctrine()->getManager();
            $user = $newUserForm->getData();
            $user->setRoles(['ROLE_USER']);
            $user->setBirthday(new \DateTime());
            $em->persist($user);
            $em->flush();
            // $this->sendConfirmationEmailMessage($user);
            // if ($cer) {
            //     return $this->redirectToRoute('wait_view', []);
            // }
            $isOk = true;
        }
        return $this->render('signup/registration.html.twig', [
            'userInscriptionForm' => $newUserForm->createView(),
            'isOk' => $isOk
        ]);
    }
    // private function sendConfirmationEmailMessage(User $user)
    // {
    //     $transport = (new \Swift_SmtpTransport('mailhog', 1025));
    //     $mailer = new \Swift_Mailer($transport);
    //     $url = $this->generateUrl('token', ['token' => $user->getToken()]);
    //     $renderTemplate = $this->render(
    //         'annonce/mail-confirm-registration.html.twig',
    //         ['user' => $user,
    //             'token' => $user->getToken(),
    //         ]
    //     );
    //     $message = (new \Swift_Message('Confirmation Email'))
    //         ->setFrom('admin@local.com')
    //         ->setReplyTo('admin@local.com')
    //         ->setTo($user->getmail())
    //         ->setBody(
    //             $renderTemplate,
    //             "text/html"
    //         );
    //     $mailer->send($message);
    // }

    /**
     * @Route(path="registred", name="user_registration_confirmed")
     */
    // public function registrationConfirmed()
    // {
    //     return $this->render('annonce/registration-confirmed.html.twig');
    // }
    /**
     * @Route(path="/wait", name="wait_view")
     */
    // public function waitView()
    // {
    //     return $this->render('annonce/wait-confirmation.html.twig');
    // }
}