<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\assets;

use yii\web\AssetBundle;

class Auth0LockAsset extends AssetBundle
{
    public $js = [
        'https://cdn.auth0.com/js/lock-7.5.min.js',
    ];
    public $depends = [
    ];
}
