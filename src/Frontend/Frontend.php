<?php
namespace Ramphor\User\Frontend;

use Ramphor\User\Frontend\Menu\Item;
use Ramphor\User\Frontend\Scripts;
use Ramphor\User\Frontend\Callback;

class Frontend
{
    protected static $instance;

    protected $menuItemInstance;
    protected $templateDir;
    protected $themePrefix;

    public function __construct($templateDir = null, $themePrefix = 'profiles')
    {
        $this->menuItemInstance = Item::instance();
        $this->templateDir = $templateDir;
        $this->themePrefix = $themePrefix;

        $this->init();
    }

    public static function instance($templateDir = null, $themePrefix = 'profiles')
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($templateDir, $themePrefix);
        }
        return self::$instance;
    }

    public function init()
    {
        add_filter(
            'walker_nav_menu_start_el',
            array($this->menuItemInstance, 'render'),
            10,
            4
        );
        add_action('wp_enqueue_scripts', array(Scripts::class, 'register'));

        /**
         * Make the callback URL to authorize account via socials
         */
        $GLOBALS['rp_user_profile']= new Callback($this->templateDir, $this->themePrefix);
    }
}
