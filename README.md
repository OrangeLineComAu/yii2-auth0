anli\auth0
==========
Yii2 Auth0

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

    php composer.phar require --prefer-dist anli/yii2-auth0 "*"

or add

    "anli/yii2-auth0": "*"

to the require section of your `composer.json` file.

Run migration with:

    php yii migrate/up --migrationPath=@vendor/anli/yii2-auth0/migrations

Configuration
-----

Update the `modules` section with:

    'auth0' => [
        'serviceId' => '',
        'class' => 'anli\auth0\Module',
        'domain' => '',
        'clientId' => '',
        'clientSecret' => '',
        'redirectUri' => 'http://localhost:8100/auth0/user/login',
    ],

Login to auth0 and update the `Allowed Callback Urls` in your setting page.

Update the `components` section in the config with:

    'user' => [
        'loginUrl' => ['auth0/user/login'],  
    ],

Usage
-----
