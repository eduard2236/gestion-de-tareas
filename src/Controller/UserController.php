<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Form\RegisterType;

class UserController extends AbstractController
{
   
    public function register(Request $request): Response
    {
        $user= new user();
        $form = $this->createForm(RegisterType::class, $user);
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
