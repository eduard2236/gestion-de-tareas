<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Animal;
use Symfony\Component\Mime\Message;

class AnimalController extends AbstractController
{
    /**
     * @Route("/animal", name="app_animal")
     */
    public function index(): Response {
         //cargar el repositorio desde doctrine
         $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
        $animales = $animal_repo = $animal_repo->findAll();

        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
            'animales' => $animales
        ]);
    }

    public function save(){
        //guardar en la base de datos

        //carga entity manager
        $entityManager = $this->getDoctrine()->getManager();
        //creo el objeto y le doy valores
        //instancio del modelo animal
        $animal= new Animal;
        //seteo los valore del objeto animal
        $animal->setTipo('avestruz');
        $animal->setColor('verde');
        $animal->setRaza('africana');

        //guardar el objeto en doctrine
        $entityManager->persist($animal);

        //volcar datos en la tabla/guarda datos en la base de datos
        $entityManager->flush();

        return new Response('<h1>el animal guardado tiene el id: '.$animal->getId().'</h1>' );
    }

    public function animal($id){
        //cargar el repositorio desde doctrine
        $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
        //consulta en bd
        $animal = $animal_repo->find($id);

        if(!$animal){
            $Message = 'el animal no existe';
        }else{
            $Message = 'TU ANIMAL ES: '. $animal->getTipo().' ' .$animal->getRaza();
        }

        return new Response($Message);
    }
}
