<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use anli\metronic\widgets\Portlet;

/* @var $this yii\web\View */
/* @var $model anli\auth0\models\Tenant */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="tenant-form">

<?php $form = ActiveForm::begin(['id' => $model->formName(),
    'options' => ['class' => 'modalSubmit'],
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
]); ?>

    <?php Portlet::begin(['id' => 'tenant-portlet', 'title' => $this->title ? 'Create Tenant' : $this->title,
        'buttons' => [
            Html::submitButton('<i class="fa fa-check"></i> <u>U</u>pdate', ['class' => 'btn green-haze btn-circle', 'value' => "form#{$model->formName()}", 'accesskey' => 'u',]),
        ],
    ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php Portlet::end(); ?>

<?php ActiveForm::end(); ?>

</div>
