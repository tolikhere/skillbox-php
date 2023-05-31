<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Service\FileUploader;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ArticlesController extends AbstractController
{
    public function __construct(private ArticleRepository $articleRepository)
    {
    }

    #[IsGranted('ROLE_ADMIN_ARTICLE')]
    #[Route(path: '/admin/articles', name: 'app_admin_articles')]
    public function index(Request $request): Response
    {
        $queryBuilder = $this->articleRepository->latestQueryBuilder($request->query->get('q'));
        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            $request->query->get('itemsPerPage', 20)
        );
        return $this->render('admin/article/index.html.twig', [
            'pager' => $pagerfanta
        ]);
    }

    #[Route(path: '/admin/articles/create', name: 'app_admin_articles_create')]
    public function create(Request $request, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(ArticleFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();

            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $imageFilename = $fileUploader->uploadArticleImage($imageFile, $article->getImageFilename());
                $article->setImageFilename($imageFilename);
            }

            $this->articleRepository->save($article, true);

            $this->addFlash('success', 'article.created_successfully');

            return $this->redirectToRoute('app_admin_articles');
        }
        return $this->render('admin/article/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[IsGranted('ARTICLE_EDIT', subject: 'article')]
    #[Route(path: '/admin/articles/{id}/edit', name: 'app_admin_articles_edit')]
    public function edit(Article $article, Request $request, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(ArticleFormType::class, $article, options: [
            'enabled_published_at' => true,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();

            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $imageFilename = $fileUploader->uploadArticleImage($imageFile, $article->getImageFilename());
                $article->setImageFilename($imageFilename);
            }

            $this->articleRepository->save($article, true);

            $this->addFlash('success', 'article.edited_successfully');

            return $this->redirectToRoute('app_admin_articles_edit', ['id' => $article->getId()]);
        }

        return $this->render('admin/article/edit.html.twig', ['form' => $form]);
    }
}
