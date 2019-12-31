<?php
namespace Ramphor\User\Frontend;

class Callback
{
    protected $templateDir;

    public function __construct($templateDir, $themePrefix = 'profiles')
    {
        $this->setupCallback($templateDir, $themePrefix);

        add_action('init', array($this, 'register_auth_rewrite_rules'), 10, 0);
        add_filter('query_vars', array($this, 'register_new_query_vars'));
        add_filter('template_redirect', array($this, 'load_authorize_template'));
    }

    protected function setupCallback($templateDir = null, $themePrefix = 'profiles')
    {
        $this->templateDir = $templateDir;
        $this->themePrefix = $themePrefix;
    }

    public function register_auth_rewrite_rules()
    {
        add_rewrite_rule('auth/login/?$', 'index.php?ramphor=auth&action=login', 'top');
    }

    public function register_new_query_vars($vars)
    {
        $vars = array_merge(
            $vars,
            [ 'ramphor', 'action', 'social']
        );
        return $vars;
    }

    public function load_authorize_template($template)
    {
        if (isset($_SERVER['REQUEST_URI']) && $this->checkIsRamphorAuth($_SERVER['REQUEST_URI'])) {
        }
        return $template;
    }

    protected function checkIsRamphorAuth()
    {
        return true;
    }
}
