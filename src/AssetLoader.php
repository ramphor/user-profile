<?php
namespace Ramphor\User;

class AssetLoader
{
    protected $assetDirectoryUri;

    public function __construct()
    {
        $abspath = constant('ABSPATH');
        $rootDir = constant('RAMPHOR_USER_PROFILE_ROOT_DIR');
        if (PHP_OS === 'WINNT') {
            $abspath = str_replace('\\', '/', $abspath);
            $rootDir = str_replace('\\', '/', $rootDir);
        }
        $this->assetDirectoryUri = sprintf(
            '%s/assets',
            str_replace($abspath, site_url('/'), $rootDir)
        );
    }


    public function assetURL($path = '')
    {
        return sprintf(
            '%s/%s',
            $this->assetDirectoryUri,
            $path
        );
    }

    public function load()
    {
        global $wp_scripts;

        if (!isset($wp_scripts->registered['micromodal'])) {
            wp_register_script(
                'micromodal',
                $this->assetURL('micromodal.min.js'),
                array(),
                '0.4.6',
                true
            );
        }

        wp_enqueue_script('micromodal');
    }
}
