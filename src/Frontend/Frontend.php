<?php
namespace Ramphor\User\Frontend;

use Ramphor\User\Frontend\Menu\Item;

class Frontend
{
    protected static $instance;

    protected $menuItemInstance;

    public function __construct()
    {
        $this->menuItemInstance = Item::instance();
        $this->init();
    }

    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
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
    }
}
