<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Support\Facades\Date;
use Override;

class PasswordConfirmation extends RequirePassword
{
    /**
     * Determine if the confirmation timeout has expired.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $passwordTimeoutSeconds
     * @return bool
     */
    #[Override]
    protected function shouldConfirmPassword($request, $passwordTimeoutSeconds = null)
    {
        if ($request->user()?->is_external) {
            return false;
        }

        $confirmedAt = Date::now()->unix() - $request->session()->get('auth.password_confirmed_at', 0);

        return $confirmedAt > ($passwordTimeoutSeconds ?? $this->passwordTimeout);
    }
}
