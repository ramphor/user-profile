<?php
/**
 * Ramphor user profile helpers
 * These functions will be called from other plugins, themes
 *
 * @package Ramphor\User\Profile
 * @author Puleeno Nguyen
 */


function ramphor_user_profile_url() {
}

if ( ! function_exists( 'is_my_profile' ) ) {
    function is_my_profile() {
        global $wp_query;
        return isset($wp_query->is_ramphor_my_profile) && $wp_query->is_ramphor_my_profile;
    }
}

if ( ! function_exists( 'is_user_profile' ) ) {
    function is_user_profile($user_type = null) {
        if (is_null($user_type)) {
            return get_query_var('ramphor_user_profile') != '';
        }
        return get_query_var('ramphor_user_profile') === $user_type;
    }
}


function ramphor_user_profile_template($template, $data = array(), $id = null, $echo = true) {
    return \Ramphor\User\UserTemplateLoader::render($template, $data, $id, $echo);
}

function ramphor_user_profile_my_profile_schemes() {
    $schemes = array(
        'aquatic' => 'Aquatic',
        'blue' => 'Blue',
        'classic-blue' => 'Classic Blue',
        'classic-bright' => 'Classic Bright',
        'classic-dark' => 'Classic Dark',
        'coffee' => 'Coffee',
        'contrast' => 'Contrast',
        'ectoplasm' => 'Ectoplasm',
        'light' => 'Light',
        'midnight' => 'Midnight',
        'modern' => 'Modern',
        'nightfall' => 'Nightfall',
        'ocean' => 'Ocean',
        'powder-snow' => 'Powder Snow',
        'sakura' => 'Sakura',
        'sunrise' => 'Sunrise',
        'sunset' => 'Sunset',
    );

    return apply_filters('ramphor_user_profile_schemes', $schemes);
}

function ramphor_user_profile_get_active_scheme() {
    return 'aquatic';
}
