<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Adds an optional hash which will be appended to the auto-generated
     * redirect URL.
     *
     * This is useful when a form is not on top of the page to which the user is
     * being redirected, so that the browser will automatically scroll down to
     * the correct location in the page and the user can see the form and its
     * error messages.
     *
     * Do not prefix this value with the actual hash symbol "#", e.g. if you
     * want to redirect the user to "http://example.com/foo#bar", just set this
     * value to "bar".
     *
     * @var string|null
     */
    protected $redirectHash;

    /**
     * @inheritDoc
     */
    protected function getRedirectUrl(): string
    {
        $redirectUrl = parent::getRedirectUrl();

        if ($this->redirectHash) {
            $redirectUrl .= "#{$this->redirectHash}";
        }

        return $redirectUrl;
    }

    /**
     * Returns the configured redirect hash.
     *
     * Useful to keep things DRY in case of, for example, a controller using
     * this request needs to redirect to the same hash in the case of successful
     * form submission.
     *
     * @return string|null
     */
    public function getRedirectHash(): ?string
    {
        return $this->redirectHash;
    }
}
