<?php

namespace Ramphor\User\Admin\Extra;

class Menu
{
    public function __construct()
    {
        add_filter('manage_nav-menus_columns', array( $this, 'add_meta_box'));
    }

    public function add_meta_box($columns)
    {
        add_meta_box(
            'jankx-customize-menu-items',
            __('User Profile', 'rp_user_profile'),
            array($this, 'custom_menu_items'),
            'nav-menus',
            'side',
            'default'
		);

		return $columns;
    }

    public function custom_menu_items()
    {
    }
}
