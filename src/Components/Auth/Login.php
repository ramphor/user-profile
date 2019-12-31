<?php
namespace Ramphor\User\Components\Auth;

class Login
{
    protected $credentials;
    protected $templateDir;

    public function __construct($credentials, $templateDir = null)
    {
        $this->credentials = $credentials;
        $this->templateDir = $templateDir;

        $this->login();
    }

    public function login()
    {
        $user = wp_signon($this->credentials);
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
}
