<?php
namespace Ramphor\User\Components\Auth;

use Ramphor\User\Abstracts\Auth;
use Ramphor\User\Exceptions\ProviderException;
use Hybridauth\Exception\Exception;
use Hybridauth\HttpClient;
use Hybridauth\Provider\Facebook;
use Hybridauth\Storage\Session;

class Callback extends Auth
{
    protected $provider;

    public function do()
    {
        $provider = get_query_var('provider');
        if (!is_callable(array($this, $provider))) {
            throw new ProviderException(sprintf('The provider %s is not supported', $this->provider));
        }
        $wp_user_id = 0;
        $userProfile = call_user_func((array($this, $provider)));

        if ($userProfile) {
            $email = $userProfile->email;
            if (empty($email)) {
                $email = apply_filters(
                    'ramphor_user_profile_create_empty_email',
                    sprintf('%s@%s.com', $userProfile->identifier, $provider, $userProfile)
                );
            }

            if (!email_exists($email)) {
                $user = wp_insert_user(array(
                    'user_login' => $email,
                    'user_nicename' => sprintf('%s-%s', $provider, $userProfile->identifier),
                    'user_email' => $email,
                    'user_pass' => '',
                    'display_name' => $userProfile->displayName,
                    'first_name' => $userProfile->firstName,
                    'last_name' => $userProfile->lastName,
                ));
            }

            add_filter('authenticate', array($this, 'get_user_by_email'), 5, 2);
            $this->login(array(
                'user_login' => $email,
                'user_password' => '',
                'remember' => true,
            ));
            remove_filter('authenticate', array($this, 'get_user_by_email'), 5, 2);
        }
    }

    public function facebook()
    {
        $config = [
            'callback' => ramphor_user_profile_url('callback', 'facebook'),

            //Facebook application credentials
            'keys' => [
                'id'     => RPUP_FACEBOOK_API_KEY, //Required: your Facebook application id
                'secret' => RPUP_FACEBOOK_API_SECRET,  //Required: your Facebook application secret
            ]
        ];

        try {
            //Instantiate Facebook's adapter
            $facebook = new Facebook($config);

            //Authenticate the user
            $facebook->authenticate();

             //Returns a boolean of whether the user is connected with Facebook
             $isConnected = $facebook->isConnected();

             //Retrieve the user's profile
             return $facebook->getUserProfile();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public function get_user_by_email($user, $email)
    {
        if (!empty($email)) {
            $the_user = get_user_by('email', $email);

            return $the_user;
        }
        return $user;
    }
}
