<?php

namespace Authentication\Service;

use Account\Account;
use Firebase\JWT\JWT;

class JwtServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var JwtService
     */
    private $service;

    protected function setUp()
    {
        $this->service = new JwtService($this->getTokenConfig());
    }

    /**
     * @test
     */
    public function weAreAbleToGetToken()
    {
        $account = $this->getMockAccount();
        $token = $this->service->getToken($account);
        $this->assertTrue(is_string($token));
        $decoded = (array)JWT::decode($token, $this->getTokenConfig()['key'], ['HS256']);
        $this->assertArrayHasKey("iss", $decoded);
        $this->assertArrayHasKey("aud", $decoded);
        $this->assertArrayHasKey("iat", $decoded);
        $this->assertArrayHasKey("nbf", $decoded);
        $this->assertArrayHasKey("data", $decoded);
        $this->assertEquals($account->getId(), $decoded["data"]->id);
        $this->assertEquals($account->getEmail(), $decoded["data"]->email);
    }

    /**
     * @return array
     */
    private function getTokenConfig()
    {
        return [
            'token' => [
                "iss" => "http://api.auth.local",
                "aud" => "http://api.auth.local",
                "iat" => 1356999524,
                "nbf" => 1357000000,
            ],
            'key' => 'my-key'
        ];
    }

    /**
     * @return Account
     */
    private function getMockAccount()
    {
        $account = new Account();
        $account->setId(1);
        $account->setEmail('iancharles901223@gmail.com');
        $account->setPassword('1111111');

        return $account;
    }
}
