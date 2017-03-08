<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\widgets;

use anli\auth0\assets\Auth0LockAsset;
use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;

/**
 * This is the widget class for the Auth0Lock.
 * ```php
 * echo \anli\auth0\widgets\Auth0Lock::widget([]);
 * ```
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class Auth0Lock extends Widget
{
    /**
     * @var string
     */
    public $clientId = '';

    /**
     * @var string
     */
    public $domain = '';

    /**
     * @var string
     */
    public $icon = '';

    /**
     * @var boolean
     */
    public $redirectUrl = '';

    /**
     * @var string URL for signup link
     */
    public $signupUrl = '';

    /**
     * @var string Text to use for signin link
     */
    public $signinText = 'Login';

    /**
     * Initializes the widget.
     */
    public function init()
    {
       parent::init();

       $module = Yii::$app->getModule('auth0');
       $this->clientId = $module->clientId;
       $this->domain = $module->domain;
       $this->redirectUrl = $module->redirectUrl;
       $this->icon = $module->icon;
       $this->signupUrl = $module->signupUrl;
       $this->signinText = $module->signinText;

       Auth0LockAsset::register($this->getView());
       $this->getView()->registerJs($this->js);
    }

    /**
     * Renders the widget.
     * @return string
     */
    public function run()
    {
        // custom logo 
        echo Html::img('/images/logo.svg', ['class' => 'login-logo', 'alt' => 'My logo']);
        //echo '<h2 class="login-heading">Lorem ipsum dolor sit amet, consectetur adipiscing elit</h2>';

        // original auth0 wrapper
        echo Html::tag('div', '', ['id' => 'root', 'class' => 'login-widget']);
        
        //custom footer
        echo "<footer class=\"login-footer\"><a href=\"$this->signupUrl\">Sign up</a></footer>";
    }

    /**
     * @return string
     */
    protected function getJs()
    {
        $rememberLastLogin = Yii::$app->getModule('auth0')->rememberLastLogin;

        return <<< JS
            var lock = new Auth0Lock('{$this->clientId}', '{$this->domain}');

            var opts = {
                focusInput: true,
                rememberLastLogin: {$rememberLastLogin},
                sso: true,
                container: 'root',
                callbackURL: '{$this->redirectUrl}',
                responseType: 'code',
                authParams: {
                  scope: 'openid profile'
                },
                icon:  '{$this->icon}'
                , disableSignupAction: true
                , sso: true
                , mode : "signin"
                , gravatar : true
                , dict: $.extend(lock.\$dicts.en, { signin: $.extend(lock.\$dicts.en.signin, { action: '$this->signinText' }) })
            };            
            
            lock.show(opts);
JS;
    }
}