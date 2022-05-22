<?php

namespace App\Security;

use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JwtTokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * JwtTokenAuthenticator constructor.
     */
    public function __construct(
        private readonly DocumentManager $dm,
        private readonly string $secretKey
    ) {
    }

    public function start(\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\Security\Core\Exception\AuthenticationException $authException = null)
    {
        // TODO: Implement start() method.
    }

    public function supports(\Symfony\Component\HttpFoundation\Request $request)
    {
        return !str_contains($request->getUri(), 'doc');
    }

    public function getCredentials(\Symfony\Component\HttpFoundation\Request $request)
    {
        $bearer = substr($request->headers->get('Authorization'), 7);
        if (!$bearer) {
            return false;
        }
        return $bearer;
    }

    public function getUser($credentials, \Symfony\Component\Security\Core\User\UserProviderInterface $userProvider)
    {
        if (!$credentials) {
            return null;
        }

        $data = JWT::decode($credentials, new Key($this->secretKey, 'HS256'));
        if (!$data ) {
            throw new CustomUserMessageAuthenticationException('Invalid Token');
        }
        $data_array = (array) $data;
        return $this->dm->getRepository(User::class)->findOneBy(['email' => $data_array['email']]);

    }

    public function checkCredentials($credentials, \Symfony\Component\Security\Core\User\UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\Security\Core\Exception\AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function onAuthenticationSuccess(\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token, string $providerKey)
    {
        return null;
    }

    public function supportsRememberMe()
    {
        // TODO: Implement supportsRememberMe() method.
    }
}