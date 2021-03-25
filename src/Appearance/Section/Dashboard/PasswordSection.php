<?php
namespace Ramphor\User\Appearance\Section;

use Ramphor\User\Appearance\MyProfile\Dashboard;
use Ramphor\User\Appearance\MyProfile\Security;
use Ramphor\User\Appearance\MyProfile\AccountSetting;

class PasswordSection
{
    protected $allowedFeatures = array(
        Dashboard::FEATURE_NAME,
        Security::FEATURE_NAME,
        AccountSettings::FEATURE_NAME
    );
}
