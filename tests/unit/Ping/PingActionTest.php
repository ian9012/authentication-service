<?php namespace Ping;

use Ping\Action\PingAction;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequest;

class PingActionTest extends \Codeception\Test\Unit
{
    /**
     * @test
     */
    public function weShouldGetJsonResponse()
    {
        $action = new PingAction();
        $request = new ServerRequest();
        $response = $action->handle($request);

        $this->assertTrue($response instanceof JsonResponse);
    }
}