<?php

namespace Account\Repositories;

use Account\Account;
use Zend\Hydrator\ClassMethodsHydrator;

class ArrayAccountRepository implements AccountRepository
{
    private $hydrator;
    private $accounts = [];

    public function __construct()
    {
        $this->hydrator = new ClassMethodsHydrator();
        foreach ($this->mockStorage() as $index => $account) {
            $this->accounts[] = $this->hydrator->hydrate($account, new Account());
        }
    }

    public function getByEmailAndPassword(string $email, string $password): bool
    {
        for ($i = 0; $i < count($this->accounts); $i++) {

            /**
             * @var $account Account
             */
            $account = $this->accounts[$i];
            if ($this->isAccountFound($email, $password, $account)) {
                return true;
            }
        }
        return false;
    }

    private function mockStorage()
    {
        return [
            [
                'id' => 1,
                'email' => 'iancharles901223@gmail.com',
                'password' => '$2y$10$LLPJHghR6kI0tYo36iuRtu61rAKcjVIKZfyWfzyZOjYwdF49aPGvq'
            ],
            [
                'id' => 2,
                'email' => 'lilianameningpeter@gmail.com',
                'password' => '$2y$10$vxC2JaCHmgbzYo5XLJo6DetlL9L5/IOPY8Ap6v29ZD/ttk8BQlVMq'
            ]
        ];
    }

    /**
     * @param string $email
     * @param string $password
     * @param Account $account
     * @return bool
     */
    private function isAccountFound(string $email, string $password, Account $account): bool
    {
        return $this->isEmailMatch($email, $account->getEmail()) && password_verify($password, $account->getPassword());
    }

    /**
     * @param string $emailStorage
     * @param string $emailRequest
     * @return bool
     */
    private function isEmailMatch(string $emailRequest, string $emailStorage)
    {
        return strcmp($emailRequest, $emailStorage) === 0;
    }
}
