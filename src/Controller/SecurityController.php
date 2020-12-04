<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use App\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;

class SecurityController extends AbstractController
{

    public function __construct(AuthenticationSuccessHandler    $authenticationSuccessHandler)
    {
        $this->authenticationSuccessEvent = $authenticationSuccessHandler;
    }

    /**
     * @Route("/api/login_check", name="check", methods={"POST"})
     */
    public function check(Request $request)
    {
        $message = sprintf(
            'You need to send JSON body to obtain token eg. %s',
            JSON::encode(['username' => 'username', 'password' => 'password'])
        );

        throw new HttpException(400, $message);
    }

    /**
     * @Route("/api/token/refresh", name="refresh", methods={"GET"})
     */
    public function refresh(
        Request $request,
        TokenStorageInterface $tokenStorage,
        JWTTokenManagerInterface $jwtManager,
        EventDispatcherInterface $dispatcher
    ): Response
    {
        try {
            $user = $tokenStorage->getToken()->getUser();
            $jwt = $jwtManager->create($user);
            $response = new JWTAuthenticationSuccessResponse($jwt);
            $event = new AuthenticationSuccessEvent(['token' => $jwt], $user, $response);

            $dispatcher->dispatch($event, Events::AUTHENTICATION_SUCCESS);

            $response->setData($event->getData());

            return $response;
        } catch (Throwable $exception) {
            throw $this->handleRestMethodException($exception);
        }
    }
}
