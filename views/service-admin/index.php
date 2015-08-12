<?php

use anli\metronic\widgets\Portlet;
use anli\metronic\widgets\GridView;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */

$this->title = 'Service Admin';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Portlet::begin(['id' => 'user-portlet', 'title' => 'Users', 'subtitle' => 'showing all users...' ]); ?>

<?= GridView::widget([
    'id' => 'user-gridview',
    'dataProvider' => new ArrayDataProvider(['allModels' => $query->all(), 'pagination' => ['pageSize' => 10,]]),
    'columns' => anli\auth0\models\ApiUser::column()
        ->nickname()
        ->email()
        ->role()
        ->actions("{update-role-to-user} {remove-tenant}")
        ->all(),
]);?>

<?php Portlet::end(); ?>
