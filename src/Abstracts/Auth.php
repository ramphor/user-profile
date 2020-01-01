<?php
namespace Ramphor\User\Abstracts;

use Ramphor\User\Interfaces\Auth as AuthInterface;

class Auth implements AuthInterface
{
    public function __construct()
    {
    }

    public function login($credentials)
    {
        $user = wp_signon($credentials);
        if (is_wp_error($user)) {
        }

        wp_safe_redirect($this->getRedirect(), 302, 'Ramphor');
    }

    public function getRedirect()
    {
        $redirect_url = home_url();

        if (isset($_GET['redirect'])) {
            $redirect_url = $_GET['redirect'];
            if (!preg_match('/^https?:\/\//', $redirect_url)) {
                $redirect_url = home_url($redirect_url);
            }
        }

        return apply_filters(
            'ramphor_user_profile_logged_in_redirect_url',
            $redirect_url,
            $this->templateDir
        );
    }

    public function checkIsAjaxRequest()
    {
        if ($_SERVER) {
            var_dump($_SERVER);
            die;
        }
    }
}
