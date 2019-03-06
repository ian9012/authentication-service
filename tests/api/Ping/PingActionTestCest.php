<?php

namespace Ping;


class PingActionTestCest
{
    /**
     * @param \ApiTester $I
     * @test
     */
    public function weShouldGetAResponse(\ApiTester $I)
    {
        $I->sendGET('/ping');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('Today is '.date('d-M-Y'));
    }
}
