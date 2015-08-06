<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>

<?= \anli\auth0\widgets\ApiUserGridView::widget([
    'query' => $query,
    'columns' => anli\auth0\models\ApiUser::column()
        ->nickname()
        ->email()
        ->hasService()
        ->all(),
]);?>
