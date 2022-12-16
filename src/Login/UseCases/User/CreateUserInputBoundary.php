<?php

declare(strict_types=1);

namespace App\Login\UseCases\User;

use App\Login\Domain\ValueObjects\User;
use Exception;

final class CreateUserInputBoundary
{
    private string $name;
    private string $user;
    private string $password;
    private int $status;
    private int $type_user;
    private string $email;

    public function __construct(string $name, string $user, string $password, int $status, int $type_user, string $email)
    {
        try {
            $this->name = $name;
            $this->user = $user;
            $this->password = $password;
            $this->status = $status;
            $this->type_user = $type_user;
            $this->email = $email;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    private function getCryptPassword(): string
    {
        $options = ["cost" => 10];
        $cryptPassword = password_hash($this->password, PASSWORD_BCRYPT, $options);

        return $cryptPassword;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->getCryptPassword();
    }

    public function getTypeUser(): int
    {
        return $this->type_user;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
