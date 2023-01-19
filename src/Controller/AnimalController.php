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
         $em = $this->getDoctrine()->getManager();
         $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
         //esto carga todos los datos de la base de datos
         $animales = $animal_repo->findAll();

        //con este solo se obtiene el primer dato que encuentre
        $animal = $animal_repo->findBy([
            'raza' => 'africana',
        ],['id'=>'desc']);
            var_dump($animal);

        //query builder
        $qb = $animal_repo->createQueryBuilder('a')
                                                //->andWhere("a.raza = : raza")
                                                //->seParameter('raza' , 'americana')
                                                ->orderBy('a.id','desc')
                                                ->getQuery();
        $resulset = $qb->execute();
       

        //dql

        $dql = "SELECT a FROM App\Entity\Animal a ORDER bY a.id DESC";
        $query = $em->createQuery($dql);
        $resulset = $query->execute();

        //sql
        $connection = $this->getDoctrine()->getConnection();
        $sql = 'select * from animales order by id desc';
        $prepare = $connection->query($sql);
        $resulset = $prepare->fetchAll();
        //repository
        $animals = $animal_repo->findByRaza('DESC');
        var_dump($animals);

        
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
    public function update($id){
        //cargar doctrine
        $doctrine = $this->getDoctrine();
        //cargar entityManager
        $em = $doctrine->getManager();
        //cargar repo animal
        $animal_repo = $em->getRepository(Animal::class);
        //find para conseguir el objeto
        $animal = $animal_repo->find($id);

        //comprobar si el objeto me llega
        if(!$animal){
            $message = 'el animal no existe en la bd';
        }else{
            //asignar los valores al objeto
            $animal->setTipo("Perro $id");
        //persistir en doctrine
            $em->persist($animal);
        //guardar en la base de datos
            $em->flush();
            $message = 'has actualizado el animal : '.$animal->getId();
        }
        

        //respuesta
        return new Response($message);

    }

    public function delete(Animal $animal){
        $em = $this->getDoctrine()->getManager();

        if($animal && is_object($animal)){
            $em->remove($animal);
            $em->flush();

            $message = 'el animal ha sido borrado';
        }else{
            $message = 'el animalno existe';
        }
        return new Response($message);
    }
}
