<?php

namespace App\Security;


use App\Entity\Manager;
use App\Entity\User;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;


class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    
    private $router;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, RouterInterface $router)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->router = $router;
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'app_login'
            && $request->isMethod('POST');
                   
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            // 'csrf_token' => $request->request->get('_csrf_token'),
        ];
        // $request->getSession()->set(
        //     Security::LAST_USERNAME,
        //     $credentials['email']
        // );
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        // if (!$this->csrfTokenManager->isTokenValid($token)) {
        //     throw new InvalidCsrfTokenException();
        // }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Email could not be found.');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // Check the user's password or other credentials and return true or false
        // If there are no credentials to check, you can just return true
        if ($password = $credentials['password']) 
        {
            return true;
        } else {
            return false;
        };
        throw new \Exception('TODO: check the credentials inside '.__FILE__);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->router->generate('home'));
        // For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));
        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate('app_login');
    }
}
