<?php
namespace Ramphor\User\Appearance\Section\Dashboard;

use Ramphor\User\Abstracts\SectionAbstract;
use Ramphor\User\UserTemplateLoader;

class ProfileSection extends SectionAbstract
{
    public function getName()
    {
        return 'profile';
    }

    public function getContent()
    {
        $currentUser = wp_get_current_user();

        return UserTemplateLoader::render('my-profile/sections/profile', $this->createTemplateData(array(
            'current_user' => $currentUser,
            'current_user_id' => get_current_user_id(),
        )), null, false);
    }

    public function save()
    {
    }
}
