<?php
namespace Ramphor\User\Abstracts;

use Ramphor\User\Interfaces\SectionInterface;

abstract class SectionAbstract implements SectionInterface
{
    protected $workspace;
    protected $id;

    protected $allowedFeatures = 'all';
    protected $heading = '';
    protected $description = '';

    protected $columns = 1;
    protected $layoutStyle = 'card';

    /**
     * The percent of section width
     */
    protected $width = 100;

    public function __construct($sectionId, $workspace)
    {
        $this->id = $sectionId;
        $this->workspace = $workspace;
    }

    public function getSectionId()
    {
        return $this->id;
    }

    public function setWidth($percent)
    {
        if ($percent > 100 || $percent < 0) {
            $this->width = 100;
        } else {
            $this->width = $percent;
        }
    }

    public function getWidth()
    {
        return apply_filters(
            "{$this->workspace}_{$this->id}_section_width",
            $this->width,
            $this->id,
            $this->workspace
        );
    }

    public function setHeading($heading)
    {
        $this->heading = $heading;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    protected function createTemplateData($data = array())
    {
        return array_merge($data, array(
            'heading_text' => $this->heading,
            'description' => $this->description,
        ));
    }

    public function save()
    {
        // Save data for the section
    }
}
