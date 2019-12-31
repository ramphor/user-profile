<?php
namespace Ramphor\User\Frontend;

class Callback
{
    public function __construct()
    {
        // add_action('init', array($this, 'register_auth_rewrite_rules'), 10, 0);
        // add_filter('query_vars', array($this, 'register_new_query_vars'));
        // add_filter('parse_query', array($this, 'set_query_var'));
    }

    public function register_auth_rewrite_rules()
    {
        add_rewrite_rule('auth/login/?$', 'index.php?ramphor=auth&action=login', 'top');
    }


    public function set_query_var($query)
    {
        // var_dump(get_query_var('ramphor'));
        // die;
    }

    public function register_new_query_vars($vars)
    {
        $vars = array_merge(
            $vars,
            [ 'ramphor', 'action', 'social']
        );
        return $vars;
    }
}
