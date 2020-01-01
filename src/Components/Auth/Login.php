<?php
namespace Ramphor\User\Components\Auth;

use Ramphor\User\Abstracts\Auth;

class Login extends Auth
{
    public function do()
    {
        $credentials = array(
            'user_login' => array_get($_POST, 'rp_user_email'),
            'user_password' => array_get($_POST, 'rp_user_password'),
            'remember' => (boolean)array_get($_POST, 'remmeber_me', false),
        );

        $this->login($credentials);
    }
}
