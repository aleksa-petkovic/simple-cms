<?php

declare(strict_types=1);

namespace App\Auth\User;

use App\Auth\User;
use App\Auth\User\Notifier as UserNotifier;
use App\Auth\User\Repository as UserRepository;

class Service
{
    /**
     * A UserRepository instance.
     */
    private UserRepository $userRepository;

    /**
     * A UserNotifier instance.
     */
    private UserNotifier $userNotifier;

    /**
     * @param UserRepository $userRepository A UserRepository instance.
     * @param UserNotifier   $userNotifier   A UserNotifier instance.
     */
    public function __construct(
        UserRepository $userRepository,
        UserNotifier $userNotifier
    ) {
        $this->userRepository = $userRepository;
        $this->userNotifier = $userNotifier;
    }

    /**
     * Creates a new user.
     *
     * @param string $role             The role to assign to the user.
     * @param string $email            The user's email address.
     * @param string $password         The password for the user.
     * @param string $firstName        The user's first name.
     * @param string $lastName         The user's last name.
     * @param bool   $sendWelcomeEmail Whether to send a welcome email to the user.
     *
     * @return User
     */
    public function create(
        string $role,
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        bool $sendWelcomeEmail
    ): User {
        $user = $this->userRepository->create([
            'role' => $role,
            'email' => $email,
            'password' => $password,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);

        if ($sendWelcomeEmail) {
            $this->userNotifier->sendWelcomeEmail($user, $password);
        }

        return $user;
    }

    /**
     * Generates a new random password.
     *
     * @return string
     */
    public function generateSimplePassword(): string
    {
        return $this->userRepository->generatePassword();
    }

    /**
     * Generates a more complex random password with 16 lowercase hex digits.
     *
     * @return string
     */
    public function generateMediumPassword(): string
    {
        return bin2hex(openssl_random_pseudo_bytes(8));
    }
}
