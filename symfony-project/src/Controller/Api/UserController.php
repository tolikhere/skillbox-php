<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("IS_AUTHENTICATED_FULLY")]
class UserController extends AbstractController
{
    #[Route('/api/v1/user', name: 'app_api_user')]
    public function index(): JsonResponse
    {
        return $this->json($this->getUser(), context: ['groups' => 'main']);
    }
}
