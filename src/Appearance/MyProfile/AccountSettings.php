<?php
namespace Ramphor\User\Appearance\MyProfile;

use Ramphor\User\Abstracts\MyProfileAbstract;

class AccountSettings extends MyProfileAbstract
{
    const FEATURE_NAME = 'account-settings';

    protected $priority = 80;

    public function getName()
    {
        return static::FEATURE_NAME;
    }

    public function getMenuItem()
    {
        return array(
            'label' => __('Account Settings', 'ramphor_user_profile'),
            'url' => '#'
        );
    }

    public function render()
    {
    }
}
