<?php
namespace Ramphor\User\Abstracts;

use Ramphor\User\Interfaces\MyProfileInterface;

abstract class MyProfileAbstract implements MyProfileInterface
{
    protected $workspace;
    protected $attributes = array();
    protected $priority   = 10;

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

    public function getPriority()
    {
        $workspace = $this->workspace ? $this->workspace: 'ramphor_user_profile';
        return apply_filters(
            "{$workspace}_my_profile_{$this->getName()}_priority",
            $this->priority,
            $this
        );
    }
}
