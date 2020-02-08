<?php
namespace Ramphor\User\Abstracts;

use Ramphor\User\Interfaces\Auth as AuthInterface;

abstract class Auth implements AuthInterface
{
    const LAST_LOGGIN_KEY = '_rp_last_loggin';

    public function login($credentials, $redirectUrl = '')
    {
        $user = wp_signon($credentials);
        if (!is_wp_error($user)) {
            update_user_meta($user->ID, self::LAST_LOGGIN_KEY, time());

            /**
             * Redirect to specific URL
             */
            wp_safe_redirect($this->getRedirect('login', $redirectUrl), 302, 'Ramphor');
            exit();
        }
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
