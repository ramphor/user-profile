<?php
namespace Ramphor\User\Appearance;

use Ramphor\Core\UI\UIManager;

class Appearance {

    public function __construct() {
    }

    public function register() {
        $uiManager = UIManager::getInstance();
        $uiManager->initMenu();
    }
}
