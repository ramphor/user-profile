<?php
namespace Ramphor\User\Appearance\Section\Dashboard;

use Ramphor\User\Abstracts\FieldSectionAbstract;
use Ramphor\User\Appearance\MyProfile\Dashboard;
use Ramphor\User\UserTemplateLoader;

class ContactSection extends FieldSectionAbstract
{
    protected $allowedFeatures = array(Dashboard::FEATURE_NAME);
    protected $columns     = 2;
    protected $layoutStyle = 'horizontal-card';

    public function getName()
    {
        return 'contact';
    }

    public function getTelephoneFieldValue()
    {
    }
    public function getMobileFieldValue()
    {
    }
    public function getSkypeFieldValue()
    {
    }

    public function getFields()
    {
        $fields  = array(
            'telephone' => array(
                'label' => __('Phone', 'ramphor_user_profile'),
                'input_type' => 'text',
                'required' => false,
                'validate' => apply_filters("{$this->workspace}_field_telephone_validate_rules", array('phone'), $this),
                'value' => $this->getTelephoneFieldValue(),
            ),
            'mobile' => array(
                'label' => __('Mobile', 'ramphor_user_profile'),
                'input_type' => 'text',
                'required' => false,
                'validate' => apply_filters("{$this->workspace}_field_mobile_validate_rules", array('phone'), $this),
                'value' => $this->getMobileFieldValue(),
            ),
            'skype' => array(
                'label' => __('Skype', 'ramphor_user_profile'),
                'input_type' => 'text',
                'required' => false,
                'validate' => apply_filters("{$this->workspace}_field_skype_validate_rules", array('phone'), $this),
                'value' => $this->getSkypeFieldValue(),
            ),
        );

        return $fields;
    }
}
