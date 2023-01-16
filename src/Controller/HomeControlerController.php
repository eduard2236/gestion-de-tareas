<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeControlerController extends AbstractController
{
    /**
     * @Route("/home/controler", name="app_home_controler")
     */
    public function index(): Response
    {
        return $this->render('home_controler/index.html.twig', [
            'controller_name' => 'HomeControlerController',
            'hola' => 'hola mundo con symfony 5'
        ]);
    }

    public function animales($nombre, $apellidos){
        $title = 'Bienvenidos a la pagina de animales';
        /* array simple */
        $animales = array('perro','gato','caballo','raton');
        /* array asociativo  */
        $aves = array(
            'tipo'=>'aguila',
            'color'=> 'gris',
            'edad' => 4,
            'raza' => 'calva'
        );
        /* restorna las variables a la vista */
        return $this->render('home_controler/animales.html.twig',[
            'title' => $title, 
            'nombre' => $nombre,
            'apellidos' => $apellidos ,
            'animales' => $animales,
            'aves' => $aves
        ]);

    }
    /* redirige a una pagina */
    public function redirigir(){
       /*  return $this->redirectToRoute('animales', [
            'apellidos' => 'gutierrez ross',
            'nombre' => 'juanfelipe'
        ]); */

        return $this->redirect('http://eduardcolmenares.com');
    }
}
