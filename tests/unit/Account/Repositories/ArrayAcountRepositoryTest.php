<?php namespace Account\Repositories;

use Account\Account;

class ArrayAcountRepositoryTest extends \Codeception\Test\Unit
{
    /**
     * @var AccountRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new ArrayAccountRepository();
    }

    /**
     * @test
     */
    public function weCanGetAccountByCorrectCredentials()
    {
        $result1 = $this->repository->getByEmailAndPassword('iancharles901223@gmail.com', '123456');
        $this->assertTrue($result1 instanceof Account);
        $result2 = $this->repository->getByEmailAndPassword('lilianameningpeter@gmail.com', 'awing2803');
        $this->assertTrue($result2 instanceof Account);
    }

    /**
     * @test
     */
    public function weCannotGetAccountWithWrongCredentials()
    {
        $result1 = $this->repository->getByEmailAndPassword('iantest@gmail.com', '123456');
        $this->assertTrue($result1 instanceof Account);
        $this->assertNull($result1->getId());
        $this->assertNull($result1->getEmail());
        $this->assertNull($result1->getPassword());
    }
}
