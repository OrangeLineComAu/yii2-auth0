<?php

use anli\metronic\widgets\Portlet;
use kartik\widgets\Select2;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Timesheet */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Change Tenant';
$this->params['breadcrumbs'][] = $this->title;
$this->params['sidebarItems'] = Yii::$app->params['sidebarItems'];
?>

<div class="tenant-login-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName(),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'class' => 'modalSubmit',
    ]); ?>

    <?php Portlet::begin(['id' => $model->formName() . '-form-portlet', 'title' => $this->title,
        'buttons' => [
            Html::submitButton('<i class="fa fa-check"></i> Contin<u>u</u>e', ['class' => 'btn green-haze btn-circle', 'value' => "form#{$model->formName()}", 'accesskey' => 'u', 'data-pjax' => 0]),
        ],
    ]); ?>

    <?= $form->field($model, 'tenant_id')->widget(Select2::classname(), [
        'data' => $model->tenantSelect2Data,
        'options' => ['placeholder' => 'Select a tenant ...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);?>

    <?php Portlet::end(); ?>

    <?php ActiveForm::end(); ?>
</div>
