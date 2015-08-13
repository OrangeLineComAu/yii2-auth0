<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success modalSubmitButton', 'value' => "form#{$model->formName()}"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
