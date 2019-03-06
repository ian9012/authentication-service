<?php

namespace Account\Repositories;

interface AccountRepository
{
    public function getByEmailAndPassword(string $email, string $password): bool;
}
