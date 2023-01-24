<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\SecurityBundle\Command\UserPasswordEncoderCommand;
use Symfony\Component\Security\Core\User\User as UserUser;

class UserController extends AbstractController
{
   
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        //crear el formulario
        $user= new user();
        $form = $this->createForm(RegisterType::class, $user);
        //rellena el el objeto con los datos del formulario
        $form->handleRequest($request);
        //comprobar si el form ha sido enviado
        if($form->isSubmitted() && $form->isValid()){
            //modifica el objeto para guardarlo
            $user->setRole('ROLE_USER');
            $user->setCreatedAt(new \DateTime('now'));
            //cifrando la contraseña del usuario
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            //guardar usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('tasks');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
