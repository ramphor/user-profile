<?php
namespace Ramphor\User\Appearance\Form;

use Ramphor\User\UserTemplateLoader;

class RegisterForm
{
    public function render()
    {
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
                <div class="field-icon">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><path d="M510.702,438.722c-2.251-10.813-12.84-17.754-23.657-15.503c-10.814,2.251-17.755,12.843-15.503,23.656c1.297,6.229-0.248,12.613-4.236,17.519c-2.31,2.841-7.461,7.606-15.999,7.606H60.693c-8.538,0-13.689-4.766-15.999-7.606c-3.989-4.905-5.533-11.29-4.236-17.519c20.756-99.695,108.691-172.521,210.24-174.977c1.759,0.068,3.526,0.102,5.302,0.102c1.782,0,3.556-0.035,5.322-0.103c71.532,1.716,137.648,37.947,177.687,97.66c6.151,9.175,18.574,11.625,27.75,5.474c9.174-6.151,11.625-18.575,5.473-27.749c-32.817-48.944-80.47-84.534-134.804-102.417C370.538,220.036,392,180.477,392,136C392,61.01,330.991,0,256,0S120,61.01,120,136c0,44.504,21.488,84.084,54.633,108.911c-30.368,9.998-58.863,25.555-83.803,46.069c-45.732,37.617-77.529,90.086-89.532,147.742c-3.762,18.067,0.745,36.623,12.363,50.909C25.222,503.847,42.365,512,60.693,512h390.613c18.329,0,35.472-8.153,47.032-22.369C509.958,475.345,514.464,456.789,510.702,438.722z M160,136c0-52.935,43.065-96,96-96s96,43.065,96,96c0,51.305-40.455,93.339-91.141,95.878c-1.617-0.03-3.237-0.045-4.859-0.045c-1.614,0-3.228,0.016-4.84,0.046C200.465,229.35,160,187.312,160,136z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                </div>
                <div class="input-wrap">
                    <label for="user_login"><?php _e('Username'); ?></label>
                    <input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr(wp_unslash($user_login)); ?>" size="20" autocapitalize="off" />
                </div>
            </div>
            <div class="ramphor-field">
                <div class="field-icon">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 483.3 483.3" style="enable-background:new 0 0 483.3 483.3;" xml:space="preserve"><g><g><path d="M424.3,57.75H59.1c-32.6,0-59.1,26.5-59.1,59.1v249.6c0,32.6,26.5,59.1,59.1,59.1h365.1c32.6,0,59.1-26.5,59.1-59.1v-249.5C483.4,84.35,456.9,57.75,424.3,57.75z M456.4,366.45c0,17.7-14.4,32.1-32.1,32.1H59.1c-17.7,0-32.1-14.4-32.1-32.1v-249.5c0-17.7,14.4-32.1,32.1-32.1h365.1c17.7,0,32.1,14.4,32.1,32.1v249.5H456.4z"/><path d="M304.8,238.55l118.2-106c5.5-5,6-13.5,1-19.1c-5-5.5-13.5-6-19.1-1l-163,146.3l-31.8-28.4c-0.1-0.1-0.2-0.2-0.2-0.3c-0.7-0.7-1.4-1.3-2.2-1.9L78.3,112.35c-5.6-5-14.1-4.5-19.1,1.1c-5,5.6-4.5,14.1,1.1,19.1l119.6,106.9L60.8,350.95c-5.4,5.1-5.7,13.6-0.6,19.1c2.7,2.8,6.3,4.3,9.9,4.3c3.3,0,6.6-1.2,9.2-3.6l120.9-113.1l32.8,29.3c2.6,2.3,5.8,3.4,9,3.4c3.2,0,6.5-1.2,9-3.5l33.7-30.2l120.2,114.2c2.6,2.5,6,3.7,9.3,3.7c3.6,0,7.1-1.4,9.8-4.2c5.1-5.4,4.9-14-0.5-19.1L304.8,238.55z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                </div>
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
                <a href="javascript:MicroModal.close('modal-register');" class="button button-primary" data-micromodal-trigger="modal-login"><?php _e('Log In'); ?></a>
            </p>
        </form>
        <?php
        return ob_get_clean();
    }
}
