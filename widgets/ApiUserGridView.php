<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\widgets;

use anli\auth0\models\ApiUser;
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
 * @since 1.1.0
 */
class ApiUserGridView extends Widget
{
    /**
     * @var mixed
     */
    public $query = [];

    /**
     * @var array
     */
    public $columns = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
       parent::init();

       if (empty($this->query)) {
           $this->query = ApiUser::find();
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
            'columns' => $this->columns,
            //'columns' => ['nickname'],
        ]);
    }

    /**
     * @return mixed
     */
    protected function getDataProvider()
    {
        return new ArrayDataProvider([
            'allModels' => $this->query->all(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }
}
