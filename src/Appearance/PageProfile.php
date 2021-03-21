<?php
namespace Ramphor\User\Appearance;

use Ramphor\User\UserTemplateLoader;
use Ramphor\User\UrlManager;

class PageProfile
{
    protected function get_all_features()
    {
        $features = array(
            'profile' => array(
                'label' => __('Profile', 'ramphor_user_profile'),
                'icon' => 'mdi mdi-account-cog',
                'section' => array(
                    'user_avatar',
                    'contact_info',
                    'socials',
                    'change_password'
                )
            ),
            'logout' => array(
                'label' => __('Logout', 'ramphor_user_profile')
            )
        );

        return apply_filters('ramphor_user_profile_features', $features);
    }

    public function render_nav()
    {
    }

    public function render_content()
    {
    }

    public function render($atts, $content = '')
    {
    }
}
