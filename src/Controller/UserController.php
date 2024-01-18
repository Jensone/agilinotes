<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/u')]
class UserController extends AbstractController
{
    #[Route('/', name: 'users')]
    public function users(
        Request $request,
        UserRepository $userRepository,
        PaginatorInterface $paginator
    ): Response
    {
        $users = $paginator->paginate(
            $userRepository->findAll(),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('user/users.html.twig', [
            'users' => $users
        ]);
    }
    
    #[Route('/{username}', name: 'author')]
    public function author(
        User $user
    ): Response
    {
        return $this->render('user/author.html.twig', [
            'author' => $user
        ]);
    }
    
    #[Route('/account', name: 'account')]
    public function account(): Response
    {
        return $this->render('user/account.html.twig', []);
    }
}
