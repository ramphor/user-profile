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
        $accountSettingPage = $this->getOption('account_settings_page');

        return array(
            'label' => __('Account Settings', 'ramphor_user_profile'),
            'url' => $accountSettingPage ? get_permalink($accountSettingPage) : '#',
        );
    }

    public function render()
    {
    }
}
