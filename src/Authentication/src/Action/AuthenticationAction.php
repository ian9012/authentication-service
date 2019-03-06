<?php

declare(strict_types=1);

namespace Authentication\Action;

use Account\Repositories\AccountRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class AuthenticationAction implements RequestHandlerInterface
{
    /**
     * @var AccountRepository
     */
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        try {
            $payload = $request->getParsedBody();

            $this->validate($payload);

            if ($this->repository->getByEmailAndPassword($payload['email'], $payload['password'])) {
                return new JsonResponse(['status' => 'Valid Account'], 200);
            }
            return new JsonResponse(['status' => 'Invalid Account'], 400);
        } catch (\Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    private function validate(array $payload)
    {
        $email = $payload['email'] ?? null;
        $password = $payload['password'] ?? null;

        if (empty($email) || empty(trim($email))) {
            throw new \Exception('Please provide email', 400);
        }

        if (empty($password) || empty(trim($password))) {
            throw new \Exception('Please provide password', 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid email', 400);
        }
    }
}
