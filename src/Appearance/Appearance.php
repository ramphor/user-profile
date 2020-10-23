<?php
namespace Ramphor\User\Appearance;

class Appearance
{
    public $menu;

    public function __construct()
    {
        $this->menu = new Menu();
    }

    public function register()
    {
        $this->menu->load();
    }
}
