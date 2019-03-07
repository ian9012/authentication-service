<?php namespace Authentication\Action;

use Account\Account;
use Account\Repositories\ArrayAccountRepository;
use Authentication\Service\JwtService;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequest;

class AuthenticationActionTest extends \Codeception\Test\Unit
{
    /**
     * @var AuthenticationAction
     */
    private $action;

    protected function init($email, $password, Account $account)
    {
        $service = $this->prophesize(JwtService::class);
        $service->getToken($account)->willReturn('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.
        eyJpc3MiOiJodHRwOlwvXC9hcGkuYXV0aC5sb2NhbCIsImF1ZCI6Imh0dHA6XC9cL2FwaS5hdXRo
        LmxvY2FsIiwiaWF0IjoxMzU2OTk5NTI0LCJuYmYiOjEzNTcwMDAwMDAsImRhdGEiOnsiaWQiOjEsI
        mVtYWlsIjoiaWFuY2hhcmxlczkwMTIyM0BnbWFpbC5jb20ifX0.6ZQbAzJsO2k251uKBRIwgW6BUDJ1i2vrSa06sBw2eKM');
        $repository = $this->prophesize(ArrayAccountRepository::class);
        $repository->getByEmailAndPassword($email, $password)->willReturn($account);
        $this->action = new AuthenticationAction($repository->reveal(), $service->reveal());
    }

    /**
     * @test
     */
    public function weGetAValidAccountResponse()
    {
        $credentials = [
            'email' => 'iancharles901223@gmail.com',
            'password' => '123456',
        ];

        $account = new Account();
        $account->setId((rand(0, 100) + 1));
        $account->setEmail($credentials['email']);
        $account->setPassword($credentials['password']);
        $this->init($credentials['email'], $credentials['password'], $account);
        $response = $this->action->handle($this->getServerRequest($credentials));
        $this->assertTrue($response instanceof JsonResponse);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function weGetAnInvalidAccountResponseWithWrongPassword()
    {
        $credentials = [
            'email' => 'iancharles901223@gmail.com',
            'password' => 'awing2801',
        ];
        $this->init($credentials['email'], $credentials['password'], new Account());
        $response = $this->action->handle($this->getServerRequest($credentials));
        $this->assertTrue($response instanceof JsonResponse);
        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function weGetAnInvalidAccountResponseWithNoCredentials()
    {
        $credentials = [
            'email' => '',
            'password' => '',
        ];
        $this->init($credentials['email'], $credentials['password'], new Account());
        $response = $this->action->handle($this->getServerRequest($credentials));
        $this->assertTrue($response instanceof JsonResponse);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertStringContainsString('Please provide email', $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function weGetAnInvalidAccountResponseWithEmptyEmail()
    {
        $credentials = [
            'email' => '',
            'password' => 'awing2801',
        ];
        $this->init($credentials['email'], $credentials['password'], new Account());
        $response = $this->action->handle($this->getServerRequest($credentials));
        $this->assertTrue($response instanceof JsonResponse);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertStringContainsString('Please provide email', $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function weGetAnInvalidAccountResponseWithNoEmail()
    {
        $credentials = [
            'password' => 'awing2801',
        ];
        $this->init(null, $credentials['password'], new Account());
        $response = $this->action->handle($this->getServerRequest($credentials));
        $this->assertTrue($response instanceof JsonResponse);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertStringContainsString('Please provide email', $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function weGetAnInvalidAccountResponseWithNoPassword()
    {
        $credentials = [
            'email' => 'iancharles901223@gmail.com',
            'password' => '',
        ];
        $this->init($credentials['email'], $credentials['password'], new Account());
        $response = $this->action->handle($this->getServerRequest($credentials));
        $this->assertTrue($response instanceof JsonResponse);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertStringContainsString('Please provide password', $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function weGetAnInvalidAccountResponseWithEmptyPassword()
    {
        $credentials = [
            'email' => 'iancharles901223@gmail.com',
        ];
        $this->init($credentials['email'], null, new Account());
        $response = $this->action->handle($this->getServerRequest($credentials));
        $this->assertTrue($response instanceof JsonResponse);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertStringContainsString('Please provide password', $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function weGetAnEmailErrorResponseWithAnInvalidEmail()
    {
        $credentials = [
            'email' => 'iancharles901223@',
            'password' => 'awing2801',
        ];
        $this->init($credentials['email'], $credentials['password'], new Account());
        $response = $this->action->handle($this->getServerRequest($credentials));
        $this->assertTrue($response instanceof JsonResponse);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertStringContainsString('Invalid email', $response->getBody()->getContents());
    }

    private function getServerRequest(array $credentials): ServerRequestInterface
    {
        return (new ServerRequest())->withParsedBody($credentials);
    }
}