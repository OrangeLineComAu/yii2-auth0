<?php

namespace anli\auth0\controllers;

use anli\auth0\models\Tenant;
use anli\auth0\models\TenantSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * TenantController implements the CRUD actions for Tenant model.
 */
class TenantController extends Controller
{
    /**
     * @var string
     */
    const MODEL_FULL_NAME = 'anli\auth0\models\Tenant';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'delete-all' => [
               'class' => 'anli\helper\actions\DeleteAll',
               'modelFullName' => self::MODEL_FULL_NAME,
               'noTenant' => true,
            ],
        ];
    }
    /**
     * Lists all Tenant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TenantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tenant model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tenant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tenant();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->response->format = Response::FORMAT_JSON;
             return [
                'message' => 'successful',
             ];
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && isset($_POST['ajax'])) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        return $this->renderAjax('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Tenant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model = new Tenant();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->response->format = Response::FORMAT_JSON;
             return [
                'message' => 'successful',
             ];
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && isset($_POST['ajax'])) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        return $this->renderAjax('create', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing Tenant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->goBack();
    }

    /**
     * Finds the Tenant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tenant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tenant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * validation via AJAX
     * @return mixed
     */
    public function actionAjaxValidation($id = null)
    {
        if (isset($id)) {
            $model = $this->findModel($id);
        } else {
            $model = new Tenant;
        }

        $model->load(Yii::$app->request->post());

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);
    }
}
