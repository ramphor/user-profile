<?php
namespace Ramphor\User\Appearance\Form;

use Ramphor\User\UserTemplateLoader;

class RegisterForm
{
    public function render()
    {
        if (! get_option('users_can_register')) {
            wp_redirect(site_url('wp-login.php?registration=disabled'));
            exit;
        }

        $user_login = '';
        $user_email = '';
        $login_link_separator = apply_filters('login_link_separator', ' | ');
        $http_post     = ( 'POST' === $_SERVER['REQUEST_METHOD'] );

        if ($http_post) {
            if (isset($_POST['user_login']) && is_string($_POST['user_login'])) {
                $user_login = wp_unslash($_POST['user_login']);
            }

            if (isset($_POST['user_email']) && is_string($_POST['user_email'])) {
                $user_email = wp_unslash($_POST['user_email']);
            }

            $errors = register_new_user($user_login, $user_email);

            if (! is_wp_error($errors)) {
                $redirect_to = ! empty($_POST['redirect_to']) ? $_POST['redirect_to'] : 'wp-login.php?checkemail=registered';
                wp_safe_redirect($redirect_to);
                exit;
            }
        }

        $registration_redirect = ! empty($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';

        /**
         * Filters the registration redirect URL.
         *
         * @since 3.0.0
         *
         * @param string $registration_redirect The redirect destination URL.
         */
        $redirect_to = apply_filters('registration_redirect', $registration_redirect);

        ob_start();

        ?>
        <form name="registerform" id="registerform" action="<?php echo esc_url(site_url('wp-login.php?action=register', 'login_post')); ?>" method="post" novalidate="novalidate">
            <div class="ramphor-field">
                <div class="input-wrap">
                    <label for="user_login"><?php _e('Username'); ?></label>
                    <input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr(wp_unslash($user_login)); ?>" size="20" autocapitalize="off" />
                </div>
            </div>
            <div class="ramphor-field">
                <div class="input-wrap">
                    <label for="user_email"><?php _e('Email'); ?></label>
                    <input type="email" name="user_email" id="user_email" class="input" value="<?php echo esc_attr(wp_unslash($user_email)); ?>" size="25" />
                </div>
            </div>
            <?php

            /**
             * Fires following the 'Email' field in the user registration form.
             *
             * @since 2.1.0
             */
            do_action('register_form');

            ?>
            <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
            <p class="submit">
                <button type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Register'); ?>">
                    <?php esc_attr_e('Register'); ?>
                </button>
                <a href="javascript:MicroModal.close('modal-register');" class="button button-primary" data-micromodal-trigger="modal-login">Login</a>
            </p>
        </form>
        <?php
        return ob_get_clean();
    }
}
