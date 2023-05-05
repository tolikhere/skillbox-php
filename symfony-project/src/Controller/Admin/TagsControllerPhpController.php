<?php

namespace App\Controller\Admin;

use App\Repository\TagRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN_TAG')]
class TagsControllerPhpController extends AbstractController
{
    #[Route('/admin/tags', name: 'app_admin_tags')]
    public function index(Request $request, TagRepository $tagRepository): Response
    {
        $queryBuilder = $tagRepository->createOrderedByCreatedAtQueryBuilder(
            $request->query->get('q'),
            $request->query->has('showDeleted')
        );

        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            $request->query->get('itemsPerPage', 20)
        );
        return $this->render('admin/tags/index.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }
}
