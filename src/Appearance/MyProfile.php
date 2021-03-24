<?php
namespace Ramphor\User\Appearance;

use Ramphor\User\UserTemplateLoader;
use Ramphor\User\Interfaces\MyProfileInterface;
use Ramphor\User\Appearance\MyProfile\Home;
use Ramphor\User\Appearance\MyProfile\Logout;

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
        }
    }

    protected function getAllFeatures()
    {
        $featureClasses = apply_filters(
            "{$this->workspace}_my_profile_features",
            array(
                Home::FEATURE_NAME   => Home::class,
                Logout::FEATURE_NAME => Logout::class,
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
            'type' => Home::FEATURE_NAME,
        ), $attributes);

        $profileType    = array_get($globalAttributes, 'type');
        $currentFeature = $myProfileFeatures[$profileType];
        if (!$currentFeature) {
            return sprintf(__('My profile type "%s" is invalid', 'ramphor_user_profile'), $profileType);
        }
        $currentFeature->setAttributes($attributes);

        $featureContent = apply_filters(
            "{$this->workspace}_my_profile_feature_content",
            $currentFeature->render()
        );

        return UserTemplateLoader::render('my-profile', array(
            'unique_id' => $this->workspace,
            'menu_items' => array_filter($menuItems),
            'fixed_menu_position' => apply_filters(
                "{$this->workspace}_my_profile_fixed_menu_position",
                'left'
            ),
            'feature_content' => $featureContent,
            'feature_name' => $currentFeature->getName(),
        ), null, false);
    }

    public static function getFeature($name) {
        if (isset(static::$features[$name])) {
            return static::$features[$name];
        }
    }
}
