<?php namespace Authentication\Action;

use Account\Repositories\ArrayAccountRepository;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequest;

class AuthenticationActionTest extends \Codeception\Test\Unit
{
    /**
     * @var AuthenticationAction
     */
    private $action;

    protected function setUp()
    {
        $this->action = new AuthenticationAction(new ArrayAccountRepository());
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