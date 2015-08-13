<?php

use anli\metronic\widgets\Portlet;
use anli\metronic\widgets\GridView;
use anli\auth0\models\ApiUser;
use anli\auth0\models\Tenant;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Service Admin';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <!-- BEGIN user portlet -->
    <div class="col-md-6">
    <?php Portlet::begin(['id' => 'user-portlet', 'title' => 'Users', 'subtitle' => 'showing all users...' ]); ?>

    <?= GridView::widget([
        'id' => 'user-gridview',
        'dataProvider' => new ArrayDataProvider(['allModels' => $userQuery->all(), 'pagination' => ['pageSize' => 10,]]),
        'columns' => ApiUser::column()
            ->nickname()
            ->email()
            ->role()
            ->actions("{update-role-to-user} {remove-tenant}")
            ->all(),
    ]);?>

    <?php Portlet::end(); ?>
    </div>
    <!-- END user portlet -->

    <!-- BEGIN tenant portlet -->
    <div class="col-md-6">
    <?php Pjax::begin(['id' => 'container-pjax']); ?>
    <?php Portlet::begin(['id' => 'tenant-portlet', 'title' => 'Tenants', 'subtitle' => 'showing all tenants...',
        'buttons' => [
            Html::a('<i class="fa fa-plus"></i>', false, ['value' => Url::to(['tenant/create']), 'title' => 'Create Tenant', 'class' => 'showModalButton btn btn-circle green-haze btn-sm']),
            Html::a('<i class="fa fa-trash"></i>', ['tenant/delete-all'], ['title' => 'Delete All Tenant', 'class' => 'btn btn-circle red btn-sm', 'data-confirm' => 'Are you sure you want to delete all items?', 'data-method' => 'post', 'data-pjax' => 0]),
        ],
    ]); ?>

    <?= GridView::widget([
        'id' => 'tenant-gridview',
        'dataProvider' => new ActiveDataProvider(['query' => $tenantQuery, 'pagination' => ['pageSize' => 10,]]),
        'columns' => Tenant::column()
            ->name()
            ->users()
            ->actions()
            ->all(),
    ]);?>

    <?php Portlet::end(); ?>
    <?php Pjax::end(); ?>
    </div>
    <!-- END tenant portlet -->

</div>
