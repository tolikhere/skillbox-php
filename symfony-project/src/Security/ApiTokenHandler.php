<?php

namespace App\Security;

use App\Repository\ApiTokenRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class ApiTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private ApiTokenRepository $apiTokenRepository,
        private LoggerInterface $apiLogger,
        private RequestStack $requestStack
    ) {
    }
    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        $token = $this->apiTokenRepository->findOneBy([
            'token' => $accessToken,
        ]);

        if (! $token) {
            throw new BadCredentialsException('Invalid token.');
        }

        $user = $token->getUser();
        $request = $this->requestStack->getCurrentRequest();

        if (($isExpired = $token->isExpired())  || ! $user->isIsActive()) {
            throw new CustomUserMessageAuthenticationException(
                $isExpired ? 'Token expired.' : 'The user is not active.'
            );
        }
        // Logging the current user's information
        $this->apiLogger->info('An Authorized user', [
            'userName' => $user->getFirstName(),
            'token' => $accessToken,
            'routeName' => $request->attributes->get('_route'),
            'url' => $request->getUri(),
        ]);

        return new UserBadge($user->getUserIdentifier());
    }
}
