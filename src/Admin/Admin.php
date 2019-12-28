<?php
namespace Ramphor\User\Admin;

use Ramphor\User\Admin\Extra\Menu;

class Admin
{
    public function __construct()
    {
        $this->initHooks();
    }

    public function initHooks()
    {
        new Menu();
    }
}
