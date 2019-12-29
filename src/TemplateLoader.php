<?php
namespace Ramphor\User;

class TemplateLoader
{
    protected static $instances = [];

    protected $templateDirectory;
    protected $themePrefix;

    public function __construct($templateDirectory, $themePrefix)
    {
        $this->templateDirectory = $templateDirectory;
        $this->themePrefix = $themePrefix;
    }

    public static function instance($templateDirectory = null, $themePrefix = 'profiles')
    {
        if (is_null($templateDirectory)) {
            $templateDirectory = sprintf('%s/templates', RAMPHOR_USER_PROFILE_ROOT);
        }

        if (empty(self::$instances[$templateDirectory])) {
            self::$instances[$templateDirectory] = new self($templateDirectory, $themePrefix);
        }
        return self::$instances[$templateDirectory];
    }

    public function searchTemplate($templates)
    {
        $themeTemplates = array_map(function ($value) {
            return sprintf('templates/%s/%s.php', $this->themePrefix, $value);
        }, (array)$templates);

        $template = locate_template($themeTemplates, false);
        if ($template) {
            return $template;
        }

        foreach ((array)$templates as $template) {
            $template = sprintf('%s/%s.php', $this->templateDirectory, $template);
            if (file_exists($template)) {
                return $template;
            }
        }
    }
}
