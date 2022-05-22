<?php

namespace App\Controller;

use App\Document\User;
use DateTimeImmutable;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api')]
class SecurityController extends AbstractController
{
    /**
     * JwtTokenAuthenticator constructor.
     */
    public function __construct(
        private readonly string $secretKey
    ) {
    }
    
    #[Route(path: '/login', name: 'login', methods: ['POST'])]
    public function login(): Response
    {
        if (null === $this->getUser()) {
            return $this->json([
                                 'message' => 'missing credentials',
                  ], Response::HTTP_UNAUTHORIZED);
         }

        $secretKey = $this->secretKey;
        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+60 minutes')->getTimestamp();
        $serverName = "http://localhost:9185";
        $email   = $this->getUser()->getEmail();
        $payload = [
            'iat'  => $issuedAt->getTimestamp(),         // Issued at:  : heure à laquelle le jeton a été généré
            'iss'  => $serverName,                       // Émetteur
            'nbf'  => $issuedAt->getTimestamp(),         // Pas avant..
            'exp'  => $expire,                           // Expiration
            'email' => $email,
        ];

        $token = JWT::encode($payload, $secretKey, 'HS256');

        return new JsonResponse(['token' => $token]);
    }
}
