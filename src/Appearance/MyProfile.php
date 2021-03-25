<?php
namespace Ramphor\User\Appearance;

use Ramphor\User\UserTemplateLoader;
use Ramphor\User\Interfaces\MyProfileInterface;
use Ramphor\User\Appearance\MyProfile\Dashboard;
use Ramphor\User\Appearance\MyProfile\Logout;
use Ramphor\User\Appearance\MyProfile\AccountSettings;

class MyProfile
{
    protected $workspace;

    protected static $features     = array();
    protected static $hasShortcode = false;

    public function __construct($workspace)
    {
        if (!empty($workspace)) {
            $this->workspace = $workspace;
        }

        add_action('init', array($this, 'init'));
        if (!self::$hasShortcode) {
            add_action('wp', array($this, 'hasShortcode'));

            self::$hasShortcode = true;
        }
    }

    protected function getShortcode()
    {
        return sprintf(
            '%s_user_profile',
            $this->workspace
        );
    }

    public function hasShortcode()
    {
        if (is_singular('page')) {
            global $post;
            if (has_shortcode($post->post_content, $this->getShortcode())) {
                $GLOBALS['wp_query']->is_ramphor_my_profile = true;
            }
        }
    }

    public function init()
    {
        if ($this->workspace) {
            add_shortcode(
                $this->getShortcode(),
                array($this, 'registerShortcode')
            );
            add_filter('body_class', array($this, 'loadUserProfileScheme'));
        }
    }

    public function loadUserProfileScheme($classes)
    {
        if (is_my_profile()) {
            $classes[] = sprintf('scheme-%s', ramphor_user_profile_get_active_scheme());
        }

        return $classes;
    }

    protected function getAllFeatures()
    {
        $featureClasses = apply_filters(
            "{$this->workspace}_my_profile_features",
            array(
                Dashboard::FEATURE_NAME => Dashboard::class,
                Logout::FEATURE_NAME => Logout::class,
                AccountSettings::FEATURE_NAME => AccountSettings::class,
            ),
            $this->workspace
        );

        $features = array();
        foreach ($featureClasses as $name => $featureClass) {
            if (!class_exists($featureClass)) {
                $classNotFoundMessage = sprintf(__('Class "%s" is not found', 'ramphor_user_profile'), $featureClass);
                error_log($classNotFoundMessage);

                continue;
            }
            $feature = new $featureClass();
            if (is_a($feature, MyProfileInterface::class) && !isset($this->features[$feature->getName()])) {
                $feature->setWorkspace($this->workspace);

                $features[$feature->getName()] = $feature;
                $feature->init();
            }
        }

        $featureKeys = array_keys($features);
        usort($featureKeys, function ($keyA, $keyB) use ($features) {
            $featureA = $features[$keyA];
            $featureB = $features[$keyB];

            return $featureA->getPriority() - $featureB->getPriority();
        });

        foreach ($featureKeys as $sortedKey) {
            static::$features[$sortedKey] = &$features[$sortedKey];
        }

        return apply_filters(
            "{$this->workspace}_my_profile_features_instances",
            static::$features,
            $this->workspace
        );
    }

    protected function createAttributeValue($value, $attribute = null)
    {
        switch (gettype($value)) {
            case 'array':
                return implode(' ', array_filter($value));
            default:
                return trim($value);
        }
    }

    protected function buildHtmlAttributes($attributes)
    {
        $ret = '';
        foreach ($attributes as $attribute => $value) {
            $ret = sprintf('%s="%s"', $attribute, $this->createAttributeValue($value, $attribute));
        }
        return $ret;
    }

    protected function getProfileAvatar()
    {
         return UserTemplateLoader::render(
             'my-profile/profile-avatar',
             array(
                'current_user' => wp_get_current_user(),
             ),
             null,
             false
         );
    }

    public function registerShortcode($attributes, $content = '')
    {
        $myProfileFeatures = $this->getAllFeatures();

        $menuItems = array_map(function ($feature) {
            $menuItem = $feature->getMenuItem();
            if (is_array($menuItem) && count($menuItem) > 0) {
                $menuItem['type'] = $feature->getName();

                return $menuItem;
            }
        }, $myProfileFeatures);

        $globalAttributes = shortcode_atts(array(
            'type' => Dashboard::FEATURE_NAME,
        ), $attributes);

        $profileType    = array_get($globalAttributes, 'type');
        $currentFeature = $myProfileFeatures[$profileType];
        if (!$currentFeature) {
            return sprintf(__('My profile type "%s" is invalid', 'ramphor_user_profile'), $profileType);
        }
        $currentFeature->setAttributes($attributes);

        if ($currentFeature->isDataSubmit()) {
            // Init action to save data
            $currentFeature->saveDataActions();

            // Call save action on each workspace and each features
            do_action("{$this->workspace}_{$currentFeature->getName()}_save_data");
        }

        $featureContent = apply_filters(
            "{$this->workspace}_my_profile_feature_content",
            $currentFeature->render()
        );
        $wrapperCssClasses = array(
            'ramphor-user-profile',
            $this->workspace . '-user-profile',
        );

        if (apply_filters("{$this->workspace}_my_profile_fixed_sidebar", true)) {
            $wrapperCssClasses[] = 'fixed-sidebar';
            if (($pos = apply_filters("{$this->workspace}_my_profile_fixed_sidebar_position", 'left'))) {
                $wrapperCssClasses[] = 'menu-position-' . $pos;
            }
        }

        return UserTemplateLoader::render('my-profile', array(
            'unique_id' => $this->workspace,
            'menu_items' => array_filter($menuItems),
            'wrapper_attributes' => $this->buildHtmlAttributes(array(
                'class' => $wrapperCssClasses,
            )),
            'feature_content' => $featureContent,
            'feature_name' => $currentFeature->getName(),
            'profile_avatar' => $this->getProfileAvatar(),
        ), null, false);
    }

    public static function getFeature($name)
    {
        if (isset(static::$features[$name])) {
            return static::$features[$name];
        }
    }
}
