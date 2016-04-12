<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model anli\auth0\models\Tenant */

$this->title = 'Update Tenant: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tenants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tenant-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
