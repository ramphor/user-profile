<?php
namespace Ramphor\User\Components\LoginStyle;

class Enum
{
    const LOGIN_STYLE_WORDPRESS_NATIVE = 'native';
    const LOGIN_STYLE_PAGE_TEMPLATE    = 'page';
    const LOGIN_STYLE_POPUP_MODAL      = 'modal';

    protected $loginStyle;

    public function __construct($enum)
    {
        if (!$this->validateEnum($enum)) {
            throw new \Exception(
                sprintf('Login style %s is not supported', $enum)
            );
        }
        $this->loginStyle = $enum;
    }

    public function validateEnum($enum)
    {
        $reflection = new \ReflectionClass($this);
        return in_array(
            $enum,
            array_values(
                $reflection->getConstants()
            )
        );
    }

    public function __toString()
    {
        return $this->loginStyle;
    }
}
