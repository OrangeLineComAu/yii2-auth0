<?php

use anli\auth0\models\ApiUser;
use anli\metronic\widgets\Portlet;
use anli\metronic\widgets\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\alert\AlertBlock;
/* @var $this yii\web\View */
/* @var $model anli\auth0\models\Tenant */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tenants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['sidebarItems'] = Yii::$app->controller->module->sidebarItems;
?>
<!-- BEGIN Alert Block -->
<?= AlertBlock::widget([
        'delay' => 0,
        'useSessionFlash' => true,
        'type' => AlertBlock::TYPE_ALERT,
    ]);
?>
<!-- END Alert Block -->
<div class="row">
    <!-- BEGIN user portlet -->
    <div class="col-md-6">
    <?php Portlet::begin(['id' => 'user-portlet', 'title' => 'Users Permission', 'subtitle' => 'for this tenant...' ]); ?>

    <?= GridView::widget([
        'id' => 'user-gridview',
        'dataProvider' => new ArrayDataProvider(['allModels' => ApiUser::find()->orderBy('email:1')->all(), 'pagination' => ['pageSize' => 10,]]),
        'columns' => ApiUser::column()
            ->nickname()
            ->email()
            ->role($model->name)
            ->actions("{update-role-to-user} {remove-tenant}")
            ->all(),
    ]);?>

    <?php Portlet::end(); ?>
    </div>
    <!-- END user portlet -->
</div>
