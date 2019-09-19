<?php
namespace Ramphor\User;

class Profile
{
    protected static $instances;

    protected $templateDirectory;
    protected $loginStyles;

    public static function init(array $args = [])
    {
        $args = wp_parse_args($args, array(
            'templates_location' => sprintf('%s/templates', realpath(dirname(__FILE__) . '/../')),
            'login_styles' => ['native', 'page'],
        ));

        if (empty($instances[$args['templates_location']])) {
            $instances[$args['templates_location']] = new self($args);
        }
        return $instances[$args['templates_location']];
    }

    public function __construct($args)
    {
        if (empty($args['templates_location'])) {
            throw new \Exception(sprintf(
                'Please use method %1$s::init() is instance for %1$s::__construct()',
                Profile::class
            ));
        }
        $this->templateDirectory = $args['templates_location'];
        if (isset($args['login_styles'])) {
            foreach ((array)$args['login_styles'] as $loginStyle) {
                $loginStyle = new LoginStyle\Enum($loginStyle);
                $this->loginStyles[] = $loginStyle;
            }
        }
    }
}
