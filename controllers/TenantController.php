<?php

namespace anli\auth0\controllers;

use anli\auth0\models\Tenant;
use anli\auth0\models\TenantLoginForm;
use anli\auth0\models\TenantSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use kartik\growl\Growl;
use yii\filters\AccessControl;

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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'delete-all', 'import', 'export',
                            'view', 'create', 'update', 'delete',
                            'ajax-validation', 'delete-checkbox',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->controller->module->isAdmin;
                        }
                    ],
                    [
                        'actions' => [
                            'login',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
            'import' => [
                'class' => 'anli\helper\actions\ImportAction',
                'importModelName' => '\anli\auth0\models\Tenant',
                'attributes' => [
                    'name' => 'name',
                ],
            ],
            'export' => [
				'class' => 'anli\helper\actions\ExportAction',
				'query' => Tenant::find(),
				'attributes' => [
					'name' => 'name',
				],
			],
            'update' => [
                'class' => 'anli\helper\actions\UpdateAction',
                'model' => Tenant::findOne(Yii::$app->getRequest()->getQueryParam('id')),
            ],
            'create' => [
                'class' => 'anli\helper\actions\CreateAction',
                'model' => new Tenant,
            ],
        ];
    }

    /**
     * Displays a single Tenant model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        Yii::$app->user->setReturnUrl(['/' . $this->getRoute(), 'id' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
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

        Yii::$app->getSession()->setFlash('success', 'You have deleted a tenant!');
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

    /**
     * @param string
     * @return string
     */
    public function actionDeleteCheckbox($keylist)
    {
        $keylist = explode(",", $keylist);

        $count = count($keylist);

        foreach ($keylist as $id) {
            $this->findModel($id)->delete();
        }

        Yii::$app->getSession()->setFlash('success', "You have deleted $count tenant!");

        return $this->goBack();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
           'message' => $keylist,
        ];
    }

    /**
     * Login Tenant model.
     * If creation is successful, the browser will be redirected back
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new TenantLoginForm;

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && isset($_POST['ajax'])) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        return $this->renderAjax('login', [
            'model' => $model,
        ]);
    }
}
