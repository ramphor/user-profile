<?php
namespace Ramphor\User\Appearance\MyProfile;

use Ramphor\User\Abstracts\MyProfileAbstract;

class Logout extends MyProfileAbstract
{
    const FEATURE_NAME = 'logout';

    protected $priority = 999;

    public function getName()
    {
        return static::FEATURE_NAME;
    }

    public function getMenuItem()
    {
        return array(
            'url' => '#',
            'label' => __('Logout'),
        );
    }

    public function render()
    {
    }
}
