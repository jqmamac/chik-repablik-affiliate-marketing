<?php

namespace backend\controllers;

use backend\models\MemberPackage;
use backend\models\MemberPackagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MemberPackageController implements the CRUD actions for MemberPackage model.
 */
class MemberPackageController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['login', 'error'],
                            'allow' => true,
                        ],
                        [
                            'actions' => ['member-package', 'index', 'create', 'update', 'activate', 'delete'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all MemberPackage models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MemberPackagesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MemberPackage model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MemberPackage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MemberPackage();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $filling_date = strtotime($model->filling_date);
                $model->filling_date = date('Y-m-d',$filling_date);
                $model->save();

                if (isset($_GET['id'])){
                    return $this->redirect(['user/view', 'id' => $_GET['id']]);
                }else{
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        if (isset($_GET['id'])){
            $model->user_id = $_GET['id'];
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MemberPackage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($this->request->isPost && $model->load($this->request->post())) {
           
            $filling_date = strtotime($model->filling_date);
            $model->filling_date = date('Y-m-d',$filling_date);

            if($model->save()){
                if (isset($_GET['from'])){
                    return $this->redirect(['user/view', 'id' => $_GET['from']]);
                }else{
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }       
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MemberPackage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
        try {
            $this->findModel($id)->delete();
            if (isset($_GET['from'])){
                return $this->redirect(['user/view', 'id' => $_GET['from']]);
            }else{
                return $this->redirect(['index']);
            }
        } catch (IntegrityException $e) {
            
            throw new NotFoundHttpException(Yii::t('app', 'Unable to delete affiliate.'));
        }       
    }

    /**
     * Finds the MemberPackage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MemberPackage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MemberPackage::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Activate an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionActivate($id)
    {
        $model = $this->findModel($id);

        if($model->status == 'active')
        {   
            $model->status = 'expired';
        }
        
        if ($model->save()) {
            return $this->redirect(['user/view', 'id' => $_GET['from']]);
        }
       
    }
}
