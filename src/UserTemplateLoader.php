<?php
namespace Ramphor\User;

class UserTemplateLoader
{
    public static $loaderInstances;
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

    public static function search($template, $id = null)
    {
        if (empty(static::$loaderInstances)) {
            $searchedTemplate = $this->getDefaultTemplate($template);
        } else {
            if (is_null($id)) {
                $loader = array_get(array_values(static::$loaderInstances), 0);
            } else {
                $loader = static::get($id);
            }
            $searchedTemplate = $loader->searchTemplate($template);

            if (!$searchedTemplate) {
                $searchedTemplate = static::getDefaultTemplate($template);
            }
        }
        return $searchedTemplate;
    }

    public static function render($template, $data = array(), $id = null, $echo = true)
    {
        if (empty(static::$loaderInstances)) {
            $searchedTemplate = $this->getDefaultTemplate($template);
        } else {
            if (is_null($id)) {
                $loader = array_get(array_values(static::$loaderInstances), 0);
            } else {
                $loader = static::get($id);
            }
            $searchedTemplate = $loader->searchTemplate($template);

            if (!$searchedTemplate) {
                $searchedTemplate = static::getDefaultTemplate($template);
            }
        }

        if ($searchedTemplate) {
            extract($data);

            ob_start();
            require $searchedTemplate;

            $renderedContent = ob_get_clean();
            if (!$echo) {
                return $renderedContent;
            }
            echo $renderedContent;
        }
    }
}
