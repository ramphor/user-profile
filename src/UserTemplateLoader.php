<?php
namespace Ramphor\User;

class UserTemplateLoader
{
    protected static $loaderInstances;
    protected static $templatesDir;

    public static function add($id, $templateLoader)
    {
        if (!isset(static::$loaderInstances[$id])) {
            static::$loaderInstances[$id] = $templateLoader;
            return true;
        }
        return false;
    }

    public static function get($id)
    {
        if (isset(static::$loaderInstances[$id])) {
            return static::$loaderInstances[$id];
        }
    }

    public static function getDefaultTemplate($template)
    {
        if (is_null(static::$templatesDir)) {
            static::$templatesDir = dirname(__DIR__) . '/templates';
        }
        if (!is_array($template)) {
            $template = array($template);
        }

        foreach ($template as $t) {
            $searchedTemplate = sprintf('%s/%s.php', static::$templatesDir, $t);
            if (file_exists($searchedTemplate)) {
                return $searchedTemplate;
            }
        }
        return null;
    }

    public static function render($template, $data = array(), $id = null)
    {
        if (is_null($id)) {
            $searchedTemplate = $this->getDefaultTemplate($template);
        } else {
            $searchedTemplate = static::get($id)->search($template);
            if (!$searchedTemplate) {
                $this->getDefaultTemplate($template);
            }
        }

        if ($searchedTemplate) {
            extract($data);
            require $searchedTemplate;
        }
    }
}
