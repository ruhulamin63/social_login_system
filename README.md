# # Using Social Login Package

** A social login package using demo project **

## # Download Process
```php
git clone https://github.com/ruhulamin63/social_login_system.git
```

## Installation

```bash
cp .env.example .env
```

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=root
DB_PASSWORD=
```
### Add facebook_id Column
#### In this step, first, we have to create a migration to add the facebook_id in your user table. So let's run the below command:
```bash
php artisan make:migration add_facebook_id_column
```

```bash
composer update
```
## Create database
```php
php artisan migrate
```

## Create developer account
```php
GitHub: https://github.com/settings/developers
Facebook: https://developers.facebook.com
Google: https://console.cloud.google.com
```

## Configuration Setting
** These credentials should be placed in your application's <b style="color:orange">config/services.php</b> configuration file, and should use the key <b style="color:red">facebook, twitter</b> (OAuth 1.0), twitter-oauth-2 (OAuth 2.0), <b style="color:red">linkedin, google, github, gitlab, or bitbucket,</b> depending on the providers your application requires:

## Create Facebook Developer Apps
```html
https://developers.facebook.com/apps
```
```php
return [
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],
]
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

### .env
```php
FACEBOOK_CLIENT_ID=your-client-id
FACEBOOK_CLIENT_SECRET=your-client-secret
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback
```

Copyright © All rights reserved by Ruhul Amin