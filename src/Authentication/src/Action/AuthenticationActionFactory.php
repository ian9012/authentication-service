<?php

declare(strict_types=1);

namespace Authentication\Action;

use Account\Repositories\ArrayAccountRepository;
use Psr\Container\ContainerInterface;

class AuthenticationActionFactory
{
    public function __invoke(ContainerInterface $container) : AuthenticationAction
    {
        return new AuthenticationAction(new ArrayAccountRepository());
    }
}
