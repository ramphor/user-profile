<?php
namespace Ramphor\User\Components\Auth;

use Ramphor\User\Abstracts\Auth;

class Logout extends Auth
{
    public function do()
    {
        /**
         * Logout the current user
         */
        wp_logout();

        /**
         * Redirect
         */
        wp_safe_redirect($this->getRedirect('logout'), 302, 'Ramphor');
    }
}
