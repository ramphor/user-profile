<?php
namespace Ramphor\User;

use Ramphor\User\Admin\Admin;
use Ramphor\User\Frontend\Frontend;
use Jankx\Template\Template;

class Profile
{
    const NAME = 'rp-user-profile';

    protected static $instances = [];

    protected $templateLoader;
    protected $hybridauth;
    protected $isRegistered;
    protected $templateDirectory;
    protected $themePrefix;

    public static function init($templateDirectory = '', $themePrefix = 'users')
    {
        if (empty(self::$instances[$templateDirectory])) {
            self::$instances[$templateDirectory] = new self($templateDirectory, $themePrefix);
        }
        return self::$instances[$templateDirectory];
    }

    public function __construct($templateDirectory, $themePrefix = 'users')
    {
        /**
         * Skip set up user profile if library is initialized
         */
        if (!empty($this->isRegistered)) {
            return;
        }
        $this->isRegistered = true;
        $this->templateDirectory = $templateDirectory;
        $this->themePrefix = $themePrefix;

        $this->define_constants();
        $this->includes();


        add_action('init', array($this, 'setup'));
    }

    private function define($name, $value)
    {
        if (defined($name)) {
            return;
        }
        define($name, $value);
    }

    public function define_constants()
    {
        $this->define('RAMPHOR_USER_PROFILE_ROOT', realpath(dirname(__FILE__) . '/..'));
    }

    public function includes()
    {
        /**
         * Load the Ramphor User Profile helpers
         */
        require_once RAMPHOR_USER_PROFILE_ROOT . '/helpers/common.php';
        require_once RAMPHOR_USER_PROFILE_ROOT . '/helpers/functions.php';
        require_once RAMPHOR_USER_PROFILE_ROOT . '/helpers/user.php';

        if (is_admin()) {
            new Admin();
        } elseif (!defined('DOING_AJAX') && !defined('DOING_CRON') && !$this->isApiRequest()) {
            new Frontend($this->templateDirectory, $this->themePrefix);
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
        $this->templateLoader = Template::getInstance(
            $this->templateDirectory,
            $this->themePrefix
        );
    }

    public function getTempateLoader()
    {
        return $this->templateLoader;
    }
}
