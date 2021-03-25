<?php
namespace Ramphor\User\Appearance\MyProfile;

use Ramphor\User\Abstracts\MyProfileAbstract;

class Security extends MyProfileAbstract
{
    const FEATURE_NAME = 'change-password';

    protected $priority = 90;

    public function getName()
    {
        return static::FEATURE_NAME;
    }

    public function getMenuItem()
    {
        return array(
            'label' => __('Security', 'ramphor_user_profile'),
            'url' => '#',
        );
    }

    public function render()
    {
    }
}
