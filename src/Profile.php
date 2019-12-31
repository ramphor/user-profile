<?php
namespace Ramphor\User;

use Ramphor\User\Components\LoginStyle\Enum;
use Ramphor\User\Admin\Admin;
use Ramphor\User\Frontend\Frontend;

class Profile
{
    const NAME = 'rp-user-profile';

    protected static $instances;

    protected $templateLoader;
    protected $hybridauth;

    protected $loginStyles;
    protected $isRegistered;

    public static function init(array $args = [])
    {
        $args = wp_parse_args($args, array(
            'templates_location' => sprintf('%s/templates', realpath(dirname(__FILE__) . '/../')),
            'theme_prefix' => 'profiles',
            'login_styles' => ['native', 'page', 'modal'],
        ));

        if (empty($instances[$args['templates_location']])) {
            $instances[$args['templates_location']] = new self($args);
        }
        return $instances[$args['templates_location']];
    }

    public function __construct($args)
    {
        if (empty($args['templates_location'])) {
            throw new \Exception(sprintf(
                'Please use method %1$s::init() is instance for %1$s::__construct()',
                Profile::class
            ));
        }
        $this->args = $args;

        $this->templateDirectory = $args['templates_location'];
        if (isset($args['login_styles'])) {
            foreach ((array)$args['login_styles'] as $loginStyle) {
                $loginStyle = new Enum($loginStyle);
                $this->loginStyles[] = $loginStyle;
            }
        }

        $userProfileRoot = realpath(dirname(__FILE__) . '/..');
        define('RAMPHOR_USER_PROFILE_ROOT', $userProfileRoot);

        $this->includes();
        $this->isRegistered = true;
        add_action('after_setup_theme', array($this, 'setup'));
    }

    public function includes()
    {
        /**
         * Skip set up user profile if library is initialized
         */
        if (!empty($this->isRegistered)) {
            return;
        }
        /**
         * Load the Ramphor User Profile helpers
         */
        require_once RAMPHOR_USER_PROFILE_ROOT . '/helpers/functions.php';

        if (is_admin()) {
            new Admin();
        } elseif (!defined('DOING_AJAX') && !defined('DOING_CRON') && !$this->isApiRequest()) {
            new Frontend();
        }
    }

    public function isApiRequest()
    {
        if (empty($_SERVER['REQUEST_URI'])) {
            return false;
        }
    }

    public function setup()
    {
        $args = wp_parse_args($this->args, [
            'templates_location' => null,
            'theme_prefix' => 'profiles',
        ]);
        $this->templateLoader = new TemplateLoader(
            $args['templates_location'],
            $args['theme_prefix']
        );
    }

    public function getTemplateLoader()
    {
    }
}
