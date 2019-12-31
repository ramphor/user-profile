<?php
namespace Ramphor\User\Frontend;

use Ramphor\User\TemplateLoader;
use Ramphor\User\Components\Auth\Login;

class Callback
{
    protected $templateDir;

    public function __construct($templateDir)
    {
        $this->setupCallback($templateDir);

        add_action('init', array($this, 'register_auth_rewrite_rules'), 10, 0);
        add_filter('query_vars', array($this, 'register_new_query_vars'));

        add_filter('template_include', array($this, 'load_authorize_template'));
        add_action('tempate_redirect', array($this, 'call_ramphor_actions'));
    }

    protected function setupCallback($templateDir = null)
    {
        $this->templateDir = $templateDir;
    }

    public function register_auth_rewrite_rules()
    {
        add_rewrite_rule('^auth/login/?$', 'index.php?ramphor=auth&action=login', 'top');
        add_rewrite_rule('^auth/register/?$', 'index.php?ramphor=auth&action=register', 'top');
        add_rewrite_rule(
            '^auth/callback/([^/]*)/?$',
            'index.php?ramphor=auth&action=callback&type=$matches[$1]',
            'top'
        );
    }

    public function register_new_query_vars($vars)
    {
        $vars = array_merge(
            $vars,
            [ 'ramphor', 'action', 'type']
        );
        return $vars;
    }

    public function load_authorize_template($template)
    {
        if (get_query_var('ramphor', false) === 'auth') {
            if (empty(get_query_var('action', false))) {
                return $template;
            }
            $action = get_query_var('action');

            $component;
            if ($action === 'login') {
                $component = new Login([
                    'user_login' => array_get($_POST, 'rp_user_email'),
                    'user_password' => array_get($_POST, 'rp_user_password'),
                    'remember' => (boolean)array_get($_POST, 'remmeber_me', false),
                ], $this->templateDir);
            } elseif ($action === 'register') {
            } elseif ($action === 'callback') {
            }

            if (is_callable(array($component, 'getTemplateRedirect'))) {
                return $component->getTemplateRedirect();
            }
        }

        return $template;
    }

    protected function checkIsRamphorAuth()
    {
        return true;
    }
}
