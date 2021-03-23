<?php
namespace Ramphor\User;

use Ramphor\User\Appearance\Appearance;
use Ramphor\User\Appearance\UserProfile;

class Profile
{
    const NAME = 'rp-user-profile';

    protected static $instance;
    protected $hybridauth;

    public $db;
    public $template;
    public $appearance;
    public $asset;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        if (!defined('RAMPHOR_USER_PROFILE_LOADER_FILE')) {
            define('RAMPHOR_USER_PROFILE_LOADER_FILE', __FILE__);
        }
        $this->includes();
        $this->setup();
        $this->initHooks();
    }

    public function includes()
    {
        $rootDir = realpath(dirname(RAMPHOR_USER_PROFILE_LOADER_FILE) . '/..');
        if (!defined('RAMPHOR_USER_PROFILE_ROOT_DIR')) {
            define('RAMPHOR_USER_PROFILE_ROOT_DIR', $rootDir);
        }

        // Include the helpers
        require_once $rootDir . '/helpers/functions.php';
    }

    public function setup()
    {
        $this->db = new Database();
        $this->appearance = new Appearance();
        $this->asset = new AssetLoader();
    }

    public function initHooks()
    {
        add_action(
            'after_setup_theme',
            array($this->appearance, 'register')
        );
        add_action(
            'wp_enqueue_scripts',
            array($this->asset, 'load'),
            40
        );
        add_action('init', array($this, 'registerShortcodes'));
    }

    /**
     * Register template loader for user profile
     * @param string $id   template loader ID
     * @param Jankx\Template\Loader $templateLoader the template loader instance
     */
    public function registerTemplate($id, $templateLoader)
    {
        return UserTemplateLoader::add(
            $id,
            $templateLoader
        );
    }

    public function registerShortcodes()
    {
    }

    public function registerUserProfile($slug)
    {
        $userProfile = new UserProfile($slug);
        add_action(
            'after_setup_theme',
            array($userProfile, 'register')
        );
    }
}
