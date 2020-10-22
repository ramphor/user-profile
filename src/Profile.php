<?php
namespace Ramphor\User;

use Ramphor\User\Admin\Admin;
use Ramphor\User\Frontend\Frontend;
use Jankx\Template\Template;

class Profile
{
    const NAME = 'rp-user-profile';

    protected static function $instance;
    protected $hybridauth;

    public static function getInstance() {
    }

    private function __construct() {
        $this->includes();
    }

    public function includes()
    {
    }
}
