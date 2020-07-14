<?php

declare(strict_types=1);

namespace App\Auth\User;

use App\Auth\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;

class Notifier
{
    /**
     * A Mailer instance.
     */
    protected Mailer $mailer;

    /**
     * @param Mailer $mailer A Mailer instance.
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Sends a welcome email.
     *
     * @param User   $user     A User to send a welcome email to.
     * @param string $password A newly created password.
     *
     * @return void
     */
    public function sendWelcomeEmail(User $user, string $password): void
    {
        $role = $user->role->slug;
        $subject = trans("emails/user/created/{$role}.subject");

        $this->mailer->send(
            "emails.user.created.{$role}",
            [
                'user' => $user,
                'password' => $password,
            ],
            static function (Message $message) use ($user, $subject): void {
                $message
                    ->to($user->email, $user->full_name)
                    ->subject($subject);
            },
            );
    }
}
