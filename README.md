# # Using Social Login Package

** A social login package using demo project **

## # Download Process
```php
git clone https://github.com/ruhulamin63/social_login_system.git
```

## Installation

```php
Composer update

Add .env file

php artisan serve
```
## Create database
```php
php artisan migrate
```

## Configuration Setting
** These credentials should be placed in your application's <b style="color:orange">config/services.php</b> configuration file, and should use the key <b style="color:red">facebook, twitter</b> (OAuth 1.0), twitter-oauth-2 (OAuth 2.0), <b style="color:red">linkedin, google, github, gitlab, or bitbucket,</b> depending on the providers your application requires:

## Create Facebook Developer Apps
```html
https://developers.facebook.com/apps
```
```php
'facebook' => [
    'client_id' => 'facebook_id',
    'client_secret' => 'facebook_secret',
//    'redirect' => 'http://example.com/callback-url',
    'redirect' => 'http://localhost:8000/login/facebook/callback',
],
```

## Create Google Developer Apps
```html
https://console.cloud.google.com/apis/dashboard?pli=1&project=ui-design-105
```
```php
'google' => [
    'client_id' => 'google_id',
    'client_secret' => 'google_secret',
    'redirect' => 'http://localhost:8000/login/google/callback',
],
```
## Create GitHub Developer Apps
```html
https://github.com/settings/developers
```
```php
'github' => [
    'client_id' => 'github_id',
    'client_secret' => 'github_secret',
    'redirect' => 'http://localhost:8000/login/github/callback',
],
```

Copyright © All rights reserved by [rahridoy.com](https://jahidulislamzim.com/)