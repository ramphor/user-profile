<?php
namespace Ramphor\User\Abstracts;

use Ramphor\User\Interfaces\Auth as AuthInterface;

abstract class Auth implements AuthInterface
{
    public function login($credentials, $redirectUrl = '')
    {
        $user = wp_signon($credentials);
        if (is_wp_error($user)) {
        }

        wp_safe_redirect($this->getRedirect('login', $redirectUrl), 302, 'Ramphor');
    }

    public function getRedirect($action = 'login', $defaultUrl = '')
    {

        if (isset($_REQUEST['redirect'])) {
            $redirectUrl = $_REQUEST['redirect'];
            if (!preg_match('/^https?:\/\//', $redirectUrl)) {
                $redirectUrl = home_url($redirectUrl);
            }
        } elseif (empty($redirectUrl)) {
            $redirectUrl = home_url();
        }

        return apply_filters(
            "ramphor_user_profile_{$action}_redirect_url",
            $redirectUrl,
            $this->templateDir
        );
    }

    public function checkIsAjaxRequest()
    {
    }
}
