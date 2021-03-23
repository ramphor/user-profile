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


function ramphor_user_profile_template($template, $data = array(), $id = null, $echo = true) {
    return \Ramphor\User\UserTemplateLoader::render($template, $data, $id, $echo);
}
