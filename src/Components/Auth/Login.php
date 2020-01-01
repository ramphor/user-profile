<?php
namespace Ramphor\User\Components\Auth;

use Ramphor\User\Abstracts\Auth;

class Login extends Auth
{
    protected $credentials;
    protected $templateDir;

    public function __construct($credentials, $templateDir = null)
    {
        $this->credentials = $credentials;
        $this->templateDir = $templateDir;
    }
}
