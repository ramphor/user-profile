<?php
namespace Ramphor\User\Abstracts;

use Ramphor\User\UserTemplateLoader;

abstract class FieldSectionAbstract extends SectionAbstract
{
    protected $fields = null;
    protected $supportedInputTypes = null;

    abstract public function getFields();

    public function inputTypesSupport()
    {
        if (!is_null($this->supportedInputTypes)) {
            return $this->supportedInputTypes;
        }

        $defaultSupports = array(
            'text'
        );

        return $this->supportedInputTypes = apply_filters(
            "{$this->workspace}_supported_input_types",
            $defaultSupports,
            $this
        );
    }

    protected function createTemplateData($data = array())
    {
        return array_merge($data, array(
            'fields' => apply_filters(
                "{$this->workspace}_section_fields",
                $this->wrapFieldsByFilter(),
                $this->workspace,
                $this->id,
                $this
            ),
            'section_id' => $this->id,
            'section_type' => $this->getName(),
            'heading_text' => $this->heading,
            'description' => $this->description,
        ));
    }

    public function generateFieldContent($field, $fieldId)
    {
        $inputType = array_get($field, 'input_type');
        if (!in_array($inputType, $this->inputTypesSupport())) {
            error_log(sprintf('Input type "%s" is not support defined in class "%s"', $inputType, get_called_class()));
            return;
        }

        $fieldAttributes = array(
            'name' => $fieldId,
            'id' => sprintf('%s-%s-%s', $this->workspace, $fieldId, $inputType),
        );
        if (($placeholder = array_get($field, 'placeholder'))) {
            $fieldAttributes['placeholder'] = $placeholder;
        }

        $data = array_merge($field, array(
            'workspace' => $this->workspace,
            'field_id' => $fieldAttributes['id'],
            'field_name' => $fieldId,
            'field_attributes' => jankx_generate_html_attributes(apply_filters(
                "{$this->workspace}_genrate_field_{$inputType}_attributes",
                $fieldAttributes
            )),
        ));
        if (is_null($data['value'])) {
            $data['value'] = $field['default'];
        }
        return UserTemplateLoader::render('my-profile/fields/' . $inputType, $data, null, false);
    }

    public function generateFieldsContent()
    {
        $fields = $this->wrapFieldsByFilter(true);
        $content = '';

        foreach ($fields as $id => $field) {
            $field = wp_parse_args($field, array(
                'label' => 'Field Label',
                'placeholder' => '',
                'input_type' => 'text',
                'required' => false,
                'validate' => array(),
                'default' => '',
                'value' => null,
            ));
            $content .= $this->generateFieldContent($field, $id);
        }
        return $content;
    }

    protected function wrapFieldsByFilter($forceUpdate = false)
    {
        $fields = is_null($this->fields) || $forceUpdate ? $this->getFields() : $this->fields;

        return $this->fields = apply_filters(
            "{$this->workspace}_{$this->getName()}_fields",
            $fields,
            $this->workspace,
            $this
        );
    }

    public function getContent()
    {
        return UserTemplateLoader::render(
            'my-profile/sections/fields',
            $this->createTemplateData(array(
                'fields_content' => $this->generateFieldsContent(),
            )),
            null,
            false
        );
    }

    protected function generateFieldName($name)
    {
        return sprintf('%s_%s', $this->workspace, $name);
    }

    public function save()
    {
        if (!is_user_logged_in()) {
            return false;
        }

        $fields = $this->wrapFieldsByFilter();
        foreach ($fields as $fieldId => $field) {
            if (isset($_POST[$fieldId])) {
                update_user_meta(
                    get_current_user_id(),
                    $this->generateFieldName($fieldId),
                    $_POST[$fieldId]
                );
            }
        }

        return true;
    }
}
