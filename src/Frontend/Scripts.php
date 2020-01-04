<?php
namespace Ramphor\User\Frontend;

use Ramphor\User\Profile;

class Scripts
{
    public static function register()
    {
        if (!wp_script_is('micromodal', 'registered')) {
            wp_register_script(
                'micromodal',
                ramphor_user_profile_asset_url('vendor/micromodal/micromodal.js'),
                array(),
                '0.4.2',
                true
            );
        }

        wp_register_script(
            Profile::NAME,
            ramphor_user_profile_asset_url('js/ramphor-user-profile.js'),
            array('jquery', 'micromodal'),
            '1.0.24',
            true
        );

        wp_register_style(Profile::NAME, ramphor_user_profile_asset_url('css/ramphor-user-profile.css'), array(), '1.0.24');

        /**
         * Enqueue the Ramphor User Profile scripts
         */
        wp_enqueue_script(Profile::NAME);
        wp_enqueue_style(Profile::NAME);
    }
}
