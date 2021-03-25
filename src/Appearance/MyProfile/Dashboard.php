<?php
namespace Ramphor\User\Appearance\MyProfile;

use Ramphor\User\UserTemplateLoader;
use Ramphor\User\Abstracts\MyProfileAbstract;
use Ramphor\User\Appearance\Section\Dashboard\ProfileSection;
use Ramphor\User\Appearance\Section\Dashboard\ContactSection;
use Ramphor\User\Appearance\Section\Dashboard\ConnectSocialSection;

class Dashboard extends MyProfileAbstract
{
    const FEATURE_NAME = 'dashboard';

    protected $priority = 5;
    protected $formClosed = false;
    protected $sections = array();

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

    public function init()
    {
        $this->getDashboardSections();
    }

    public function getDashboardSections()
    {
        $sections = array();

        /******************************************************************
         ** Start Profile Section
         *******************************************************************/
        $profileSection = new ProfileSection("{$this->workspace}-section_profile", $this->workspace);
        $profileSection->setHeading('Profile');
        $profileSection->setDescription('This information will be displayed publicly on your profile');
        do_action_ref_array("{$this->workspace}_profile_section_init", array(
            &$profileSection,
            $this->workspace
        ));
        $sections[] = &$profileSection;
        /******************************************************************
         ** End Profile Section
         *******************************************************************/


        /******************************************************************
         ** Start Contact Section
         *******************************************************************/
        $contactSection = new ContactSection("{$this->workspace}-section_contact", $this->workspace);
        $contactSection->setHeading('Contact Information');
        $contactSection->setDescription('Add your contact information.');
        do_action_ref_array("{$this->workspace}_contact_section_init", array(
            &$contactSection,
            $this->workspace
        ));
        $sections[] = &$contactSection;
        /******************************************************************
         ** End Contact Section
         *******************************************************************/

        /******************************************************************
         ** Start Socials Section
         *******************************************************************/
        $socialsSection = new ConnectSocialSection("{$this->workspace}-section_socials", $this->workspace);
        $socialsSection->setHeading('Social Media');
        $socialsSection->setDescription('Add your social media information.');
        do_action_ref_array("{$this->workspace}_socials_section_init", array(
            &$socialsSection,
            $this->workspace
        ));
        $sections[] = &$socialsSection;
        /******************************************************************
         ** End Socials Section
         *******************************************************************/

        return $this->sections = apply_filters(
            "{$this->workspace}_my_profile_dashboard_sections",
            $sections,
            $this
        );
    }

    public function render()
    {
        return UserTemplateLoader::render('my-profile/dashboard', array(
            'workspace' => $this->workspace,
            'sections' => $this->sections,
            'openForm' => function () {
                return $this->openForm();
            },
            'closeForm' => function () {
                return $this->closeForm();
            },
            'save_button' => $this->generateSaveProfileButton(),
        ), null, false);
    }

    protected function generateSaveProfileButton()
    {
        $buttonText = apply_filters(
            "{$this->workspace}_save_profile_button_text",
            __('Save profile details', 'wramphor_user_profile'),
            $this->workspace
        );
        $buttonAttributes = array(
            'name'  => sprintf('%s-dashboard-save-button', $this->workspace),
            'value' => wp_create_nonce($this->workspace),
        );
        return sprintf('<button %s>%s</button', jankx_generate_html_attributes($buttonAttributes), $buttonText);
    }

    protected function openForm()
    {
        $formAttributes = array(
            'id' => "{$this->workspace}-dashboard",
            'method' => 'POST',
        );
        echo sprintf('<form %s>', jankx_generate_html_attributes($formAttributes)); // wpcs: XSS ok
    }

    protected function closeForm()
    {
        if ($this->formClosed) {
            return;
        }
        echo '</form>';
        $this->formClosed = true;
    }

    public function isDataSubmit()
    {
        if (!isset($_POST['wordland-dashboard-save-button'])) {
            return false;
        }
        return wp_verify_nonce($_POST['wordland-dashboard-save-button'], $this->workspace);
    }

    public function saveDataActions()
    {
        foreach ($this->sections as $section) {
            add_action(
                "{$this->workspace}_{$this->getName()}_save_data}",
                array($section, 'save')
            );
        }
    }
}
