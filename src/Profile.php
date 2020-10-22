<?php
namespace Ramphor\User;

use Ramphor\User\Admin\Admin;
use Ramphor\User\Frontend\Frontend;
use Jankx\Template\Template;

class Profile
{
    const NAME = 'rp-user-profile';

    protected static
     $instance;
    protected $hybridauth;

    public $db;
    public $template;

    public static function getInstance() {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct() {
        if (!defined('RAMPHOR_USER_PROFILE_LOADER_FILE')) {
            define('RAMPHOR_USER_PROFILE_LOADER_FILE', __FILE__);
        }
        $this->includes();
        $this->setup();
    }

    public function includes()
    {
        $rootDir = realpath(dirname(RAMPHOR_USER_PROFILE_LOADER_FILE) . '/..');

        // Include the helpers
        require_once $rootDir . '/helpers/functions.php';
    }

    public function setup() {
        $this->db = new Database();
        $this->template = new UserTemplateLoader();
    }
}
