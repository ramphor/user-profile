<?php
namespace Ramphor\User\Appearance;

use Ramphor\Core\UI\UIManager;

class Menu
{
    public function load()
    {
        $this->initHooks();
        $this->registerMenuItem();
    }

    public function registerMenuItem()
    {
        $uiManager = UIManager::getInstance();
        $uiManager->initMenu();
    }


    public function initHooks()
    {
        add_filter('ramphor_nav_menu_items', array($this, 'registerMenuItems'));
        add_filter('ramphor_nav_menu_item_args', array($this, 'registerMenuItemsArgs'));

        // Create custom menu items
        add_filter('wp_nav_menu_objects', array($this, 'cloneMenuItems'), 10, 2);
        add_filter('walker_nav_menu_start_el', array($this, 'renderMenuItem'), 10, 3);
    }

    public function registerMenuItems($items)
    {
        $items = array_merge($items, array(
            'ramphor_account' => __('Ramphor Account', 'ramphor_user_profile'),
        ));
        return $items;
    }

    public function registerMenuItemsArgs($args)
    {
        return array_merge($args, array(
            'ramphor_account' => array(
                'type' => 'ramphor_account',
                'title' => __('Account', 'ramphor_user_profile'),
                'url' => '#',
                'classes' => 'account'
            )
        ));
    }

    protected function createLoginItem($item)
    {
        $item->url = '#';
        $item->title = __('Login');
        $item->classes[] = 'login';

        return $item;
    }

    protected function createRegisterItem($item)
    {
        $item->ID = -999;
        $item->url = '#';
        $item->title = __('Register');
        $item->classes[] = 'register';

        return $item;
    }

    public function cloneMenuItems($items, $args)
    {
        $parentId = null;
        foreach ($items as $index => $item) {
            if (!is_user_logged_in() && $parentId == $item->menu_item_parent) {
                unset($items[$index]);
                continue;
            }

            if ($item->type === 'ramphor_account') {
                if (!is_user_logged_in()) {
                    $parentId = $item->ID;
                    $offsetIndex = $index - 1;
                    $register = clone $item;
                    $new_items = array(
                        $this->createLoginItem($item),
                        $this->createRegisterItem($register)
                    );

                    array_splice($items, $offsetIndex, 1, apply_filters('ramphor_user_profile_menu_items', $new_items));
                } else {
                    $item->classes[] = 'account';
                }
            }
        }
        return $items;
    }

    public function renderMenuItem($item_output, $item, $depth)
    {
        if ($item->type === 'ramphor_account') {
        }
        return $item_output;
    }
}
