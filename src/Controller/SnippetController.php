<?php

namespace App\Controller;

use App\Repository\SnippetRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SnippetController extends AbstractController
{
    #[Route('/notes', name: 'snippets')]
    public function all(
        Request $request,
        SnippetRepository $snippetRepository,
        PaginatorInterface $paginator,
    ): Response
    {
        $notes = $paginator->paginate(
            $snippetRepository->findBy(
                ['isPublic' => true],
                ['createdAt' => 'DESC']
            ),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('snippet/all.html.twig', [
            'notes' => $notes
        ]);
    }
}
