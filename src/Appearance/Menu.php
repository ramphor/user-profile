<?php
namespace Ramphor\User\Appearance;

use Ramphor\Core\UI\UIManager;

class Menu {
    public function load() {
        $this->initHooks();
        $this->registerMenuItem();
    }

    public function registerMenuItem() {
        $uiManager = UIManager::getInstance();
        $uiManager->initMenu();
    }


    public function initHooks() {
        add_filter(
            'ramphor_nav_menu_items',
            array($this, 'registerMenuItems')
        );

        // Create custom menu items
        add_filter('wp_nav_menu_objects', array($this, 'cloneMenuItems'), 10, 2);
        add_filter('walker_nav_menu_start_el', array($this, 'renderMenuItem'), 10, 3);
    }

    public function registerMenuItems($items) {
        $items = array_merge($items, array(
            'ramphor_account' => __('Ramphor Account', 'ramphor_user_profile'),
        ));
        return $items;
    }

    protected function createLoginItem($item) {
        $item->type = 'ramphor-login-item';
        $item->url = '#';
        $item->title = __('Login');

        return $item;
    }

    protected function createRegisterItem($item) {
        $item->type = 'ramphor-register-item';
        $item->url = '#';
        $item->title = __('Register');

        return $item;
    }

    public function cloneMenuItems($items, $args) {
        foreach($items as $index => $item) {
            if($item->type === 'ramphor_account') {
                $offsetIndex = $index - 1;
                $register = clone $item;
                $new_items = array(
                    $this->createLoginItem($item),
                    $this->createRegisterItem($register)
                );

                array_splice($items, $offsetIndex , 1, apply_filters('ramphor_user_profile_menu_items', $new_items));
            }
        }
        return $items;
    }

    public function renderMenuItem($item_output, $item, $depth) {
        if ($item->type === 'ramphor_account') {
        }
        return $item_output;
    }
}