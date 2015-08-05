<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\assets;

use yii\web\AssetBundle;

/**
 * This is the asset class for the Auth0Lock.
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class Auth0LockAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $js = [
        'https://cdn.auth0.com/js/lock-7.5.min.js',
    ];
}
