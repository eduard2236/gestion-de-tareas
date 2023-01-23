<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;

class TaskController extends AbstractController
{
    
    public function index()
    {
        //prueba de entidades y relaciones
        /* $em =  $this->getDoctrine()->getManager();
        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findAll();
         foreach($tasks as $task){
            echo $task->getUser()->getEmail().': '.$task->getTittle()."<br>";
        } */

        $user_repo = $this->getDoctrine()->getRepository(User::class);
        $users = $user_repo->findAll();

        foreach( $users as $user ){
            echo "<h1> {$user->getName()} {$user->getSurname()} </h1>";
            foreach($user->getTasks() as $task){
                echo $task->getTittle()."<br>";
            }
        }

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}