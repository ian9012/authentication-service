<?php

namespace Authentication\Action;

use Psr\Container\ContainerInterface;

class AuthenticationActionFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @test
     */
    public function weCanGenerateAuthenticationActionClass()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')->willReturn($this->getConfig());
        $factory = new AuthenticationActionFactory();
        $this->assertTrue($factory($container->reveal()) instanceof AuthenticationAction);
    }

    /**
     * @return array
     */
    private function getConfig()
    {
        return [
            'jwt_token' => [
                'token' => [
                    "iss" => "http://api.auth.local",
                    "aud" => "http://api.auth.local",
                    "iat" => 1356999524,
                    "nbf" => 1357000000,
                ],
                'key' => 'my-key'
            ]
        ];
    }
}
