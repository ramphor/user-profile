<?php
namespace Ramphor\User\Appearance;

use Ramphor\User\UserTemplateLoader;

class UserProfile
{
    protected $slug;
    protected $userTemplate;

    public function __construct($slug)
    {
        if (is_string($slug) && $slug !== '') {
            $this->slug = $slug;
        }
    }

    public function register()
    {
        if (is_null($this->slug)) {
            return;
        }

        add_action('init', array($this, 'init'));
    }


    public function registerCustomQueryVars($vars)
    {
        if (!in_array('ramphor_user_profile', $vars)) {
            array_push($vars, 'ramphor_user_profile');
            array_push($vars, 'user_login');
        }
        return $vars;
    }

    public function init()
    {
        add_rewrite_rule(
            sprintf('%s/([a-zA-Z0-9_-]{1,})/?$', $this->slug),
            sprintf('index.php?ramphor_user_profile=%s&user_login=$matches[1]', $this->slug),
            'top'
        );

        add_action('wp', array($this, 'initTemplateEnvironment'), 5);

        add_filter('query_vars', array($this, 'registerCustomQueryVars'));
        add_filter('template_include', array($this, 'loadUserProfileTemplate'), 5);
        add_filter('wp_title', array($this, 'createUserWpTitle'), 5);
    }

    public function initTemplateEnvironment()
    {
        add_filter('body_class', array($this, 'createBodyClass'));
        if (!get_query_var('ramphor_user_profile')) {
            return;
        }
        $user = get_user_by('login', get_query_var('user_login'));
        if ($user) {
            $user->is_ramphor_user_profile = true;

            $GLOBALS['wp_query']->queried_object = $user;
            $GLOBALS['wp_query']->queried_object_id = $user->ID;
        }

        $userTemplate = UserTemplateLoader::search('user-profile', 'wordland');
        if ($userTemplate) {
            $GLOBALS['wp_query']->is_home = false;
            $this->userTemplate = $userTemplate;
        }
    }

    public function createBodyClass($classes)
    {
        $queried_object = get_queried_object();
        if (isset($queried_object->is_ramphor_user_profile) && $queried_object->is_ramphor_user_profile) {
            array_unshift($classes, 'ramphor-user');
        }
        $loginFormStyle = apply_filters('ramphor_user_login_form_style', 'default-login-form');
        if ($loginFormStyle) {
            $classes[] = $loginFormStyle;
        }

        return $classes;
    }

    public function loadUserProfileTemplate($template)
    {
        if ($this->userTemplate) {
            return $this->userTemplate;
        }
        return $template;
    }

    public function createUserWpTitle($title)
    {
        if (get_query_var('ramphor_user_profile') && get_query_var('ramphor_user_profile') === $this->slug) {
            $user = get_queried_object();

            if (isset($user->is_ramphor_user_profile) && $user->is_ramphor_user_profile) {
                $agentTitle = apply_filters(
                    "ramphor_user_profile_{$this->slug}_page_title",
                    sprintf('%s %s', ucfirst($this->slug), $user->display_name),
                    $user,
                    $this->slug
                );
                return sprintf('%s - %s', $agentTitle, get_bloginfo('name'));
            }
        }
        return $title;
    }
}
