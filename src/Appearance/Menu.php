<?php
namespace Ramphor\User\Appearance;

use Jankx\Component\Logo;
use Ramphor\Core\UI\UIManager;
use Ramphor\User\Appearance\Form\LoginForm;
use Ramphor\User\Appearance\Form\RegisterForm;
use Ramphor\User\UserTemplateLoader;

class Menu
{
    protected $modalInited = false;

    public function load()
    {
        $this->initHooks();
        $this->registerMenuItem();
    }

    public function registerMenuItem()
    {
        $uiManager = UIManager::getInstance();
    }


    public function initHooks()
    {
        add_filter('ramphor_nav_menu_items', array($this, 'registerMenuItems'));
        add_filter('ramphor_nav_menu_item_args', array($this, 'registerMenuItemsArgs'));

        // Create custom menu items
        add_filter('wp_nav_menu_objects', array($this, 'cloneMenuItems'), 10, 2);
        add_filter('walker_nav_menu_start_el', array($this, 'renderMenuItem'), 10, 3);
    }

    public function registerMenuItems($items)
    {
        $items = array_merge($items, array(
            'ramphor_account' => __('Ramphor Account', 'ramphor_user_profile'),
            'ramphor_logout' => __('Logout URL', 'ramphor_user_profile'),
        ));
        return $items;
    }

    public function registerMenuItemsArgs($args)
    {
        return array_merge($args, array(
            'ramphor_account' => array(
                'type' => 'ramphor_account',
                'title' => __('Account', 'ramphor_user_profile'),
                'url' => '#',
                'classes' => 'account'
            ),
            'logout_url' => array(
                'type' => 'logout_url',
                'title' => __('Logout', 'ramphor_user_profile'),
                'url' => '#',
            )
        ));
    }

    protected function createLoginItem($item)
    {
        $item->url = '#';
        $item->title = __('Login');
        $item->classes[] = 'login';

        return $item;
    }

    protected function createRegisterItem($item)
    {
        $item->ID = -999;
        $item->url = '#';
        $item->title = __('Register');
        $item->classes[] = 'register';

        return $item;
    }

    public function cloneMenuItems($items, $args)
    {
        $parentId = null;
        foreach ($items as $index => $item) {
            if (!is_user_logged_in() && $parentId == $item->menu_item_parent) {
                unset($items[$index]);
                continue;
            }

            if ($item->type === 'ramphor_account') {
                add_action('wp_footer', array($this, 'createLoginModal'));
                add_action('wp_footer', array($this, 'createRegisterModal'));
                add_action('wp_print_footer_scripts', array($this, 'initModal'));

                if (!is_user_logged_in()) {
                    $parentId = $item->ID;
                    $not_login_items = apply_filters(
                        'ramphor_user_profile_menu_not_login_items',
                        array('login')
                    );

                    if (in_array('login', $not_login_items)) {
                        $offsetIndex      = $index - 1;
                        $item->post_title = __('Log In');
                        $item->type       = 'ramphor_login';
                        $item->classes[]  = 'ramphor-login';

                        $new_items = array(
                            $this->createLoginItem($item),
                        );

                        if (in_array('register', $not_login_items)) {
                            $register             = clone $item;
                            $register->post_title = __('Register');
                            $register->type       = 'ramphor_register';
                            $register->classes[]  = 'ramphor-register';
                            $register->classes[]  = 'right';

                            $new_items[] = $this->createRegisterItem($register);

                            array_splice($items, $offsetIndex, 1, apply_filters('ramphor_user_profile_menu_items', $new_items));
                        } else {
                            $items[$index] = $new_items[0];
                            unset($new_items);
                        }
                    } elseif (in_array('register', $not_login_items)) {
                        $item->post_title = __('Register');
                        $item->type       = 'ramphor_register';
                        $item->classes[]  = 'ramphor-register';

                        $items[$index]    = $this->createRegisterItem($item);
                    }
                } else {
                    $item->classes[] = 'account';
                }
            }
        }
        return $items;
    }

    public function renderMenuItem($item_output, $item, $depth)
    {
        if (in_array($item->type, array('ramphor_account', 'ramphor_login', 'ramphor_register'))) {
            $templateFile = str_replace('ramphor_', '', $item->type);
            $item_output = UserTemplateLoader::render(
                'menu/' . $templateFile,
                array(
                    'menu_item' => $item
                ),
                apply_filters(
                    'ramphor_user_profile_use_template_loader',
                    null,
                    $item
                ),
                false
            );
        }
        return $item_output;
    }

    public function createLoginModal()
    {
        $login_form   = new LoginForm();
        $logo         = class_exists(Logo::class) ? new Logo() : false;
        $logo_content = $logo ? $logo->render() : '';

        UserTemplateLoader::render(
            'modal/login',
            array(
                'the_form'     => $login_form->render(),
                'logo_content' => $logo_content,
            )
        );
    }

    public function createRegisterModal()
    {
        $register_form = new RegisterForm();
        $logo          = class_exists(Logo::class) ? new Logo() : false;
        $logo_content  = $logo ? $logo->render() : '';

        UserTemplateLoader::render(
            'modal/register',
            array(
                'the_form'     => $register_form->render(),
                'logo_content' => $logo_content,
            )
        );
    }

    public function initModal()
    {
        if ($this->modalInited) {
            return;
        }
        ?>
        <script>
            MicroModal.init();
        </script>
        <?php
        $this->modalInited = true;
    }
}
