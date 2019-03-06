<?php

namespace Authentication;

use \ApiTester;
use Codeception\Util\HttpCode;

class AuthenticationAPICest
{
    /**
     * @param ApiTester $I
     * @test
     */
    public function weCanAuthenticateWithValidCredentials(ApiTester $I)
    {
        $credentials = [
            'email' => 'iancharles901223@gmail.com',
            'password' => '123456'
        ];
        $I->sendPOST('authenticate', $credentials);
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->canSeeResponseIsJson();
        $I->seeResponseContainsJson(['status' => 'Valid Account']);
    }

    /**
     * @param ApiTester $I
     * @test
     */
    public function weCanAuthenticateWithInvalidCredentials(ApiTester $I)
    {
        $credentials = [
            'email' => 'iancharles901223@gmail.com',
            'password' => 'awing2803'
        ];
        $I->sendPOST('authenticate', $credentials);
        $I->canSeeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->canSeeResponseIsJson();
        $I->seeResponseContainsJson(['status' => 'Invalid Account']);
    }

    /**
     * @param ApiTester $I
     * @test
     */
    public function weCanAuthenticateWithNoEmail(ApiTester $I)
    {
        $credentials = [
            'password' => '123456'
        ];
        $I->sendPOST('authenticate', $credentials);
        $I->canSeeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->canSeeResponseIsJson();
        $I->seeResponseContainsJson(['Please provide email']);
    }

    /**
     * @param ApiTester $I
     * @test
     */
    public function weCanAuthenticateWithNoPassword(ApiTester $I)
    {
        $credentials = [
            'email' => 'iancharles901223@gmail.com'
        ];
        $I->sendPOST('authenticate', $credentials);
        $I->canSeeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->canSeeResponseIsJson();
        $I->seeResponseContainsJson(['Please provide password']);
    }

    /**
     * @param ApiTester $I
     * @test
     */
    public function weCanAuthenticateWithEmptyStringPassword(ApiTester $I)
    {
        $credentials = [
            'email' => 'iancharles901223@gmail.com',
            'password' => '    '
        ];
        $I->sendPOST('authenticate', $credentials);
        $I->canSeeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->canSeeResponseIsJson();
        $I->seeResponseContainsJson(['Please provide password']);
    }

    /**
     * @param ApiTester $I
     * @test
     */
    public function weCanAuthenticateWithEmptyStringEmail(ApiTester $I)
    {
        $credentials = [
            'email' => '      ',
            'password' => '123456'
        ];
        $I->sendPOST('authenticate', $credentials);
        $I->canSeeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->canSeeResponseIsJson();
        $I->seeResponseContainsJson(['Please provide email']);
    }

    /**
     * @param ApiTester $I
     * @test
     */
    public function weCanAuthenticateWithAnInValidPassword(ApiTester $I)
    {
        $credentials = [
            'email' => 'iancharles901223@',
            'password' => '123456'
        ];
        $I->sendPOST('authenticate', $credentials);
        $I->canSeeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->canSeeResponseIsJson();
        $I->seeResponseContainsJson(['Invalid email']);
    }
}
