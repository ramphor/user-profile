<?php
namespace Ramphor\User\Abstracts;

use Ramphor\User\Interfaces\MyProfileInterface;

abstract class MyProfileAbstract implements MyProfileInterface
{
    protected $workspace;
    protected $attributes = array();
    protected $priority   = 10;
    protected $optionCallback = null;

    protected function defaultAttributes()
    {
        return array();
    }

    public function setWorkspace($workspace)
    {
        $this->workspace = $workspace;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = shortcode_atts(
            $this->defaultAttributes(),
            $attributes
        );
    }

    public function init()
    {
        // Init enviroment to run the feature
    }

    public function isDataSubmit()
    {
        return false;
    }

    public function saveDataActions()
    {
        // Default do not have any actions
    }

    public function getPriority()
    {
        $workspace = $this->workspace ? $this->workspace: 'ramphor_user_profile';
        return apply_filters(
            "{$workspace}_my_profile_{$this->getName()}_priority",
            $this->priority,
            $this
        );
    }

    public function registerOptionCallback($callable)
    {
        if (is_callable($callable)) {
            $this->optionCallback = $callable;
        }
    }

    public function getOption()
    {
        return call_user_func_array($this->optionCallback, func_get_args());
    }
}
