<?php

use anli\auth0\models\ApiUser;
use anli\metronic\widgets\Portlet;
use anli\metronic\widgets\GridView;
use yii\data\ArrayDataProvider;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\alert\AlertBlock;
/* @var $this yii\web\View */
/* @var $model anli\auth0\models\Tenant */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tenants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//$this->params['sidebarItems'] = Yii::$app->params['sidebarItems'];
?>
<div class="row">
<?php Pjax::begin(['id' => 'container-pjax', 'timeout' => false]); ?>

    <!-- BEGIN user portlet -->
    <div class="col-md-6">
    <?php Portlet::begin(['id' => 'user-portlet', 'title' => 'Users Permission', 'subtitle' => 'for this tenant...' ]); ?>

    <?= GridView::widget([
        'id' => 'user-gridview',
        'dataProvider' => new ArrayDataProvider(['allModels' => ApiUser::find()
          ->email('')
          ->orderBy('email:1')->all(), 'pagination' => ['pageSize' => 10,]]),
        'columns' => ApiUser::column()
            ->nickname()
            ->email()
            ->role($model->name)
            ->actions("{update-role-to-user} {update-role-to-admin} {remove-tenant}", $model->id)
            ->all(),
    ]);?>

    <?php Portlet::end(); ?>
    </div>
    <!-- END user portlet -->

<?php Pjax::end(); ?>
</div>
