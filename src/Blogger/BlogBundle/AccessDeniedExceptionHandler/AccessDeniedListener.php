<?php

namespace Blogger\BlogBundle\AccessDeniedExceptionHandler;

use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;

class AccessDeniedListener implements AccessDeniedHandlerInterface
{
    protected $security;

    public function __construct(AuthorizationChecker $security)
    {
        $this->security = $security;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        if ($this->security->isGranted('ROLE_USER')) {
            return new RedirectResponse('user_route');
        }
    }
}