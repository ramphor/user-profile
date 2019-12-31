<?php
namespace Ramphor\User\Frontend;

use Ramphor\User\TemplateLoader;

class Callback
{
    protected $templateDir;

    public function __construct($templateDir)
    {
        $this->setupCallback($templateDir);

        add_action('init', array($this, 'register_auth_rewrite_rules'), 10, 0);
        add_filter('query_vars', array($this, 'register_new_query_vars'));
        add_filter('template_include', array($this, 'load_authorize_template'));
    }

    protected function setupCallback($templateDir = null)
    {
        $this->templateDir = $templateDir;
    }

    public function register_auth_rewrite_rules()
    {
        add_rewrite_rule('auth/login/?$', 'index.php?ramphor=auth&action=login', 'top');
    }

    public function register_new_query_vars($vars)
    {
        $vars = array_merge(
            $vars,
            [ 'ramphor', 'action', 'social4']
        );
        return $vars;
    }

    public function load_authorize_template($template)
    {
        if (isset($_SERVER['REQUEST_URI']) && $this->checkIsRamphorAuth($_SERVER['REQUEST_URI'])) {
            $templateLoader = TemplateLoader::instance($this->templateDir);
            $template = $templateLoader->searchTemplate('callback');
            if ($template) {
                return $template;
            }
        }
        return $template;
    }

    protected function checkIsRamphorAuth()
    {
        return true;
    }
}
