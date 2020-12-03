<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use App\Traits\ResponseTrait;

use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class SecurityController extends AbstractController
{
    private $authenticationSuccessEvent;

    //extende a classe para responseTrait
    use ResponseTrait;

    public function __construct(AuthenticationSuccessHandler    $authenticationSuccessHandler)
    {
        $this->authenticationSuccessEvent = $authenticationSuccessHandler;
    }

    /**
     * @Route("/check", name="check", methods={"POST"})
     * @return TokenExtractor\TokenExtractorInterface
     */
    public function check(Request $request)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $username = $data['username'];
        $password = $data['password'];

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $username, 'password' => $password]);

        if (!$user) {
            return $this->responseNotOK('Usuario nao encontrado');
        }

        return $this->authenticationSuccessEvent->handleAuthenticationSuccess($user);

    }
}
