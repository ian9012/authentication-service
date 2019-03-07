<?php

namespace Authentication\Service;

use Account\Account;
use Firebase\JWT\JWT;

class JwtService
{
    private $token;
    private $key;

    /**
     * JwtService constructor.
     * @param array $tokenConfig
     */
    public function __construct(array $tokenConfig)
    {
        $this->token = $tokenConfig['token'];
        $this->key = $tokenConfig['key'];
    }

    /**
     * @param Account $account
     * @return string
     */
    public function getToken(Account $account): string
    {
        $data["data"] = [
            "id" => $account->getId(),
            "email" => $account->getEmail()
        ];
        $this->token = array_merge($this->token, $data);

        return JWT::encode($this->token, $this->key);
    }
}
