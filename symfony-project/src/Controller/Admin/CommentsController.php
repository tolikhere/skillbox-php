<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN_COMMENT')]
class CommentsController extends AbstractController
{
    #[Route('/admin/comments', name: 'app_admin_comments')]
    public function index(Request $request, CommentRepository $commentRepository): Response
    {
        $queryBuilder = $commentRepository->createOrderedByCreatedAtQueryBuilder(
            $request->query->get('q'),
            $request->query->has('showDeleted')
        );

        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            $request->query->get('itemsPerPage', 20)
        );
        return $this->render('admin/comments/index.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }
}
