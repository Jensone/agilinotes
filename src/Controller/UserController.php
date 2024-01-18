<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/u/{username}', name: 'author')]
    public function author(
        User $user
    ): Response
    {
        return $this->render('user/index.html.twig', [
            'author' => $user
        ]);
    }
    
    #[Route('/account', name: 'account')]
    public function account(): Response
    {
        return $this->render('user/account.html.twig', []);
    }
}
