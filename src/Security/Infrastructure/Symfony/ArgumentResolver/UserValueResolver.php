<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\ArgumentResolver;

use App\Security\Infrastructure\Symfony\Security\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Security\Core\Security;

class UserValueResolver implements ArgumentValueResolverInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        if (User::class !== $argument->getType()) {
            return false;
        }

        return $this->security->getUser() instanceof User;
    }

    /**
     * @return iterable<User>
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            return;
        }

        yield $user;
    }
}
