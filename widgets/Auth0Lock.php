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
     * @var boolean
     */
    public $redirectUrl = '';

    /**
     * Initializes the widget.
     */
    public function init()
    {
       parent::init();

       $this->clientId = Yii::$app->getModule('auth0')->clientId;
       $this->domain = Yii::$app->getModule('auth0')->domain;
       $this->redirectUrl = Yii::$app->getModule('auth0')->redirectUrl;

       Auth0LockAsset::register($this->getView());
       $this->getView()->registerJs($this->js);
    }

    /**
     * Renders the widget.
     * @return string
     */
    public function run()
    {
        echo Html::tag('div', '', ['id' => 'root', 'style' => "width: 280px; margin: 40px auto; padding: 10px; border-width: 1px;"]);
    }

    protected function getJs()
    {
        return <<< JS
            var lock = new Auth0Lock('{$this->clientId}', '{$this->domain}');
            
            lock.show({
                focusInput: true,
                rememberLastLogin: false,
                container: 'root'
              , callbackURL: '{$this->redirectUrl}'
              , responseType: 'code'
              , authParams: {
                  scope: 'openid profile'
                  }
            });
JS;
    }
}
