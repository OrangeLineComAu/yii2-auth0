<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0;

use anli\auth0\models\Auth0;

/**
 * This is the main module class.
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $layout = '@vendor/anli/yii2-auth0/views/layouts/main';

    /**
     * @var string
     */
    public $controllerNamespace = 'anli\auth0\controllers';

    /**
     * @var string
     */
    public $serviceId = '';

    /**
     * @var string
     */
    public $domain = '';

    /**
     * @var string
     */
    public $clientId = '';

    /**
     * @var string
     */
    public $clientSecret = '';

    /**
     * @var boolean
     */
    public $redirectUrl = '';

    /**
     * @var string
     */
    public $persistIdToken = true;

    /**
     * @var string
     */
    public $persistAccessToken = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return mixed
     */
    public function getAuth0()
    {
        return new Auth0([
            'domain'        => $this->domain,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUrl,
            'persist_id_token' => $this->persistIdToken,
            'persist_access_token' => $this->persistAccessToken,
        ]);
    }

    /**
     * @return mixed
     */
    public function getAuth0ByAccessToken($token)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://' . $this->domain . '/userinfo');
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["authorization: Bearer $token"]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        $response = Json::decode($response);

        if ('Unauthorized' != $response) {
            $auth0 = $this->getAuth0();
            $auth0->setUser($response);

            return $auth0;
        }

        return null;
    }
}
