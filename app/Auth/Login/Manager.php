<?php

declare(strict_types=1);

namespace App\Auth\Login;

use App\Auth\User\Repository as UserRepository;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Sentinel;
use Library\Managers\AbstractBaseManager;
use Illuminate\Session\Store as Session;
use Illuminate\Translation\Translator;

class Manager extends AbstractBaseManager
{
    /**
     * A Sentinel instance.
     */
    protected Sentinel $sentinel;

    /**
     * A Translator instance.
     */
    protected Translator $translator;

    /**
     * A Session store instance.
     */
    protected Session $session;

    /**
     * A UserRepository instance.
     */
    protected UserRepository $userRepository;

    /**
     * @param Sentinel       $sentinel       A Sentinel instance.
     * @param Translator     $translator     A translator.
     * @param Session        $session        A session store.
     * @param UserRepository $userRepository A user repository instance.
     */
    public function __construct(
        Sentinel $sentinel,
        Translator $translator,
        Session $session,
        UserRepository $userRepository
    ) {
        parent::__construct();

        $this->sentinel = $sentinel;
        $this->translator = $translator;
        $this->session = $session;
        $this->userRepository = $userRepository;
    }

    /**
     * Attempts to log the user in.
     *
     * Returns `true` on success and `false` on failure.
     *
     * If successful, the user's CSRF token will be regenerated for security
     * purposes.
     *
     * If unsuccessful, the authentication errors will be stored in
     * `$this->errors`.
     *
     * @param array $inputData The input data.
     *
     * @return bool
     */
    public function login(array $inputData): bool
    {
        $credentials = [
            'email' => $inputData['email'],
            'password' => $inputData['password'],
        ];

        $rememberMe = array_key_exists('remember_me', $inputData);

        try {
            if ($this->sentinel->authenticate($credentials, $rememberMe)) {
                $this->session->regenerateToken();

                return true;
            }
        } catch (NotActivatedException $exception) {
            $this->errors->add('email', $this->translator->get('login.errors.email.notActivated'));

            return false;
        } catch (ThrottlingException $exception) {
            $this->errors->add('email', $this->translator->get('login.errors.email.suspended'));

            return false;
        }

        $this->errors->add('email', $this->translator->get('login.errors.email.unregistered'));

        return false;
    }

    /**
     * Logs the current user out.
     *
     * The user's CSRF token will be regenerated for security purposes.
     *
     * @return bool
     */
    public function logout(): bool
    {
        $this->sentinel->logout();
        $this->session->regenerateToken();

        return true;
    }
}
