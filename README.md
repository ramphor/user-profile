# user-profile
User profile core for embed to other plugins or themes for WordPress


# How to use

```
<?php
use Ramphor\User\ProfileManager;

$profileManager = $ProfileManager::init(
  'default_template_directory',
  'template_directory'
);
```

## Register User profile page

If you want create custom user profile page for user you can register user profile via `ProfileManager`

```
$slug = 'user-profile-slug';
$profileManager->registerUserProfile($slug);
````

Example URL:
After register custom URL you can access to profile page of user `puleeno` with custom slug is `user-profile-slug` has same below format.

```
https://example.com/user-profile-slug/puleeno
```


## Register My profile page
```
$uniqueueIdToCreateHookForCustomize = 'puleeno_org';
$profileManager->registerMyProfile($uniqueueIdToCreateHookForCustomize);
```
After register `my profile` function you must create [new page](https://wordpress.org/support/article/pages/) with content has include the below shortcode.

```
[{$uniqueID}_user_profile]
```

Example:
In above PHP code you can see my unique ID is `puleeno_org`. So we has the shortcode.

```
[puleeno_org_user_profile]
```


Credits:

- Locked icon: made by [Smashicons](https://www.flaticon.com/authors/smashicons) from [www.flaticon.com](https://www.flaticon.com/)
- Envelope icon: made by [Gregor Cresnar](https://www.flaticon.com/authors/gregor-cresnar) from [www.flaticon.com](https://www.flaticon.com/)
- Bell icon: made by Those Icons from [www.flaticon.com](https://www.flaticon.com/)
