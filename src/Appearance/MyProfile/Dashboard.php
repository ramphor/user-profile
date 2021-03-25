<?php
namespace Ramphor\User\Appearance\MyProfile;

use Ramphor\User\Abstracts\MyProfileAbstract;
use Ramphor\User\UserTemplateLoader;

class Dashboard extends MyProfileAbstract
{
    const FEATURE_NAME = 'dashboard';

    protected $priority = 5;

    public function getName()
    {
        return static::FEATURE_NAME;
    }

    public function getMenuItem()
    {
        return apply_filters('ramphor_user_profile_dashboard_menu_item', array(
            'url' => '#',
            'label' => __('My profile', 'ramphor_user_profile'),
        ), $this);
    }

    public function render()
    {
    }
}