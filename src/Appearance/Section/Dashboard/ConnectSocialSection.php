<?php
namespace Ramphor\User\Appearance\Section\Dashboard;

use Ramphor\User\Abstracts\FieldSectionAbstract;
use Ramphor\User\Appearance\MyProfile\Dashboard;

class ConnectSocialSection extends FieldSectionAbstract
{
    protected $allowedFeatures = array(Dashboard::FEATURE_NAME);

    public function getName()
    {
        return 'socials';
    }

    public function getConnectedSocialValue($social_name)
    {
    }

    public function getFields()
    {
        $fields = array(
            'facebook' => array(
                'label' => __('Facebook Url', 'ramphor_user_profile'),
                'type' => 'text',
                'validate' => array('url'),
                'value' => $this->getConnectedSocialValue('facebook'),
            ),
            'twitter' => array(
                'label' => __('Twitter Url', 'ramphor_user_profile'),
                'type' => 'text',
                'validate' => array('url'),
                'value' => $this->getConnectedSocialValue('twitter'),
            ),
            'linkedin' => array(
                'label' => __('Linkedin Url', 'ramphor_user_profile'),
                'type' => 'text',
                'validate' => array('url'),
                'value' => $this->getConnectedSocialValue('linkedin'),
            ),
            'instagram' => array(
                'label' => __('Instagram Url', 'ramphor_user_profile'),
                'type' => 'text',
                'validate' => array('url'),
                'value' => $this->getConnectedSocialValue('instagram'),
            ),
            'pinterest' => array(
                'label' => __('Pinterest Url', 'ramphor_user_profile'),
                'type' => 'text',
                'validate' => array('url'),
                'value' => $this->getConnectedSocialValue('pinterest'),
            ),
            'website' => array(
                'label' => __('Website Url', 'ramphor_user_profile'),
                'type' => 'text',
                'validate' => array('url'),
                'value' => $this->getConnectedSocialValue('website'),
            ),
        );

        return $fields;
    }
}
