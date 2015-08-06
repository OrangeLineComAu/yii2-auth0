<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\widgets;

use Auth0\SDK\API\ApiUsers as Auth0ApiUsers;
use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

/**
 * This is the widget class for the Auth0 Api Users.
 * ```php
 * echo \anli\auth0\widgets\ApiUserGridView::widget([]);
 * ```
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class ApiUserGridView extends Widget
{
    /**
     * @var array
     */
    public $params = [];

    /**
     * @var string
     */
    protected $domain = '';

    /**
     * @var string
     */
    protected $token = '';

    /**
     * @var string
     */
    protected $serviceId = '';

    /**
     * Initializes the widget.
     */
    public function init()
    {
       parent::init();

       $this->domain = Yii::$app->getModule('auth0')->domain;
       $this->token = Yii::$app->getModule('auth0')->apiTokens['usersRead'];
       $this->serviceId = Yii::$app->getModule('auth0')->serviceId;

       if (empty($this->params)) {
           $this->params = [
               'sort' => 'email:1',
               'fields' => 'nickname,email,user_id,app_metadata',
               'q' => "_exists_:app_metadata.permissions.{$this->serviceId}",
               'search_engine' => 'v2',
           ];
       }
    }

    /**
     * Renders the widget.
     * @return string
     */
    public function run()
    {
        echo GridView::widget([
            'dataProvider' => $this->dataProvider,
            'columns' => [
                'nickname',
                'email',
                'user_id',
                [
                    'attribute' => 'app_metadata',
                    'value' => function ($model, $key, $index, $column){
                        return (isset($model['app_metadata'])) ?
                            yii\helpers\Json::htmlEncode($model['app_metadata']) : '';
                    }
                ]
            ],
        ]);
    }

    /**
     * @return mixed
     */
    protected function getDataProvider()
    {
        return new ArrayDataProvider([
            'allModels' => Auth0ApiUsers::search($this->domain, $this->token, $this->params)
        ]);
    }
}
