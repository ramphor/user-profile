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
        if (!is_user_logged_in()) {
            return false;
        }

        $user_data = array(
            'ID' => get_current_user_id(),
        );
        $displayName = null;

        if (!empty(($firstName = array_get($_POST, 'first_name')))) {
            $user_data['first_name'] = $firstName;
        }
        if (!empty(($lastName = array_get($_POST, 'last_name')))) {
            $user_data['last_name'] = $lastName;
        }
        if (!empty(($displayName = array_get($_POST, 'display_name')))) {
            $user_data['display_name'] = $displayName;
        }
        if (!is_null($description = array_get($_POST, 'description'))) {
            $user_data['description'] = $description;
        }

        $update_status = wp_update_user($user_data);
        if (!is_wp_error($update_status) && $update_status > 0) {
            global $current_user;
            if ($displayName !== null) {
                $current_user->display_name = $displayName;
            }
        }
        return $update_status;
    }
}
