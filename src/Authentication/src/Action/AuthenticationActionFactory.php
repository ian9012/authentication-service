<?php

declare(strict_types=1);

namespace Authentication\Action;

use Account\Repositories\ArrayAccountRepository;
use Authentication\Service\JwtService;
use Psr\Container\ContainerInterface;

class AuthenticationActionFactory
{
    public function __invoke(ContainerInterface $container) : AuthenticationAction
    {
        $config = $container->get('config');
        return new AuthenticationAction(new ArrayAccountRepository(), new JwtService($config['jwt_token']));
    }
}
