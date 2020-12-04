<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;


/**
 * @Route("/api/users", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/index", name="user_")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $users = new User($data['username']);
        $users->setPassword($data['password']);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($users);
        $manager->flush();

        return $this->json([
            'data'=> 'Usuario adicionado com sucesso.. ' 
        ]);
    }
}