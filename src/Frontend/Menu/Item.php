<?php
namespace Ramphor\User\Frontend\Menu;

use Jankx\UI\Framework;

class Item
{
    protected static $instance;

    protected $output;
    protected $item;
    protected $depth;
    protected $args;

    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function render($output, $item, $depth, $args)
    {
        if ($item->title === 'Account') {
            $this->output = $output;
            $this->item = $item;
            $this->depth = $depth;
            $this->args = $args;

            $this->createOutput();

            return apply_filters(
                'ramphor_user_profile_nav_item',
                $this->output,
                $output,
                $item,
                $depth,
                $args
            );
        }

        return $output;
    }

    public function createOutput()
    {
        if (class_exists(Framework::class)) {
            $ui = Framework::instance()->getCurrentFramework();
            $this->output = $ui->menuItem(
                $this->item,
                $this->output,
                $this->depth,
                $this->args
            );
        } else {
            $html = $this->parseItemContent();
            $this->output = wp_kses_post($html);
        }

        return $this->output;
    }

    public function parseItemContent($args = [])
    {
        $defaultArgs = array(
            'style' => 'modal',
        );
        $args = wp_parse_args($args, $defaultArgs);
    }

    public function __toString()
    {
        return $this->output;
    }
}
