<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel anli\auth0\models\TenantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tenants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tenant', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'created_at',
            'create_user_id',
            'updated_at',
            // 'update_user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
