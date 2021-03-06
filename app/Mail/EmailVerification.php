<?php

namespace App\Mail;

use App\User;

class EmailVerification extends BaseMail
{

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $code = null)
    {
        $code = $code ?: $user->email_verification_code;
        parent::__construct($user, $code);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Email Verification')
            ->view('emails.verification');
    }
}
