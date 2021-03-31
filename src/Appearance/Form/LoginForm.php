<?php
namespace Ramphor\User\Appearance\Form;

use Ramphor\User\UserTemplateLoader;

class LoginForm
{
    public function render($args = array())
    {
        $defaults = array(
            'echo'           => false,
            // Default 'redirect' value takes the user back to the request URI.
            'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
            'form_id'        => 'loginform',
            'label_username' => __('Email Address', 'ramphor_user_profile'),
            'label_password' => __('Password'),
            'label_remember' => __('Remember Me'),
            'label_log_in'   => __('Log In'),
            'id_username'    => 'user_login',
            'id_password'    => 'user_pass',
            'id_remember'    => 'rememberme',
            'id_submit'      => 'wp-submit',
            'remember'       => true,
            'value_username' => '',
            // Set 'value_remember' to true to default the "Remember me" checkbox to checked.
            'value_remember' => true,
        );

        /**
         * Filters the default login form output arguments.
         *
         * @since 3.0.0
         *
         * @see wp_login_form()
         *
         * @param array $defaults An array of default login form arguments.
         */
        $args = wp_parse_args($args, apply_filters('login_form_defaults', $defaults));

        /**
         * Filters content to display at the top of the login form.
         *
         * The filter evaluates just following the opening form tag element.
         *
         * @since 3.0.0
         *
         * @param string $content Content to display. Default empty.
         * @param array  $args    Array of login form arguments.
         */
        $login_form_top = apply_filters('login_form_top', '', $args);

        /**
         * Filters content to display in the middle of the login form.
         *
         * The filter evaluates just following the location where the 'login-password'
         * field is displayed.
         *
         * @since 3.0.0
         *
         * @param string $content Content to display. Default empty.
         * @param array  $args    Array of login form arguments.
         */
        $login_form_middle = apply_filters('login_form_middle', '', $args);

        /**
         * Filters content to display at the bottom of the login form.
         *
         * The filter evaluates just preceding the closing form tag element.
         *
         * @since 3.0.0
         *
         * @param string $content Content to display. Default empty.
         * @param array  $args    Array of login form arguments.
         */
        $login_form_bottom = apply_filters('login_form_bottom', '', $args);

        $form = UserTemplateLoader::render('login-form', array(
            'form_id' => $args['form_id'],
            'form_action' => esc_url(site_url('wp-login.php', 'login_post')),
            'id_username' => esc_attr($args['id_username']),
            'label_username' => esc_html($args['label_username']),
            'value_username' => esc_attr($args['value_username']),
            'id_password' => esc_attr($args['id_password']),
            'label_password' => esc_html($args['label_password']),
            'id_submit' => esc_attr($args['id_submit']),
            'id_remember' =>$args['id_remember'],
            'remember_password' => esc_attr($args['remember']),
            'label_remember' => esc_html($args['label_remember']),
            'value_remember' => esc_attr($args['value_remember']),
            'label_log_in' => esc_html($args['label_log_in']),
            'redirect_url' => $args['redirect'],
            'login_form_top' => $login_form_top,
            'login_form_middle' => $login_form_middle,
            'login_form_bottom' => $login_form_bottom,
        ), null, false);

        if ($args['echo']) {
            echo $form;
        } else {
            return $form;
        }
    }
}
