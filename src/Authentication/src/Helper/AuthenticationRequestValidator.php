<?php

namespace Authentication\Helper;

class AuthenticationRequestValidator
{
    private $email;
    private $password;

    public function __construct(array $request)
    {
        $this->email = $request['email'] ?? null;
        $this->password = $request['password'] ?? null;
    }

    public function validate()
    {
        if (empty($this->email) || empty(trim($this->email))) {
            throw new \Exception('Please provide email', 400);
        }

        if (empty($this->password) || empty(trim($this->password))) {
            throw new \Exception('Please provide password', 400);
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid email', 400);
        }
    }
}
