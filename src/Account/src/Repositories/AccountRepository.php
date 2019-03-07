<?php

namespace Account\Repositories;

use Account\Account;

interface AccountRepository
{
    public function getByEmailAndPassword(string $email, string $password): Account;
}
