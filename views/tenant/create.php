<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model anli\auth0\models\Tenant */

$this->title = 'Create Tenant';
$this->params['breadcrumbs'][] = ['label' => 'Tenants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
