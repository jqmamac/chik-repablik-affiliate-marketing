<?php

namespace backend\controllers;

use Yii;
use backend\models\MembersIncome;
use backend\models\Withdrawal;
use backend\models\WithdrawalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * WithdrawalController implements the CRUD actions for Withdrawal model.
 */
class WithdrawalController extends Controller
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
                            'allow' => true,
                            'actions' => ['create'],
                            'roles' => ['member','admin'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index','delete','activate', 'update'],
                            'roles' => ['admin'],
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
     * Lists all Withdrawal models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WithdrawalSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Withdrawal model.
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
     * Creates a new Withdrawal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Withdrawal();
        $modelIncome = new MembersIncome();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->user_id = $_GET['id'];
                $model->status = 'pending';
                
                $modelIncome->user_id = $model->user_id;
                $modelIncome->amount = $model->amount*-1;
                $modelIncome->type = 'withdrawal';
                
                $totali = $modelIncome->getTotalIncome($modelIncome->user_id);

                if ($totali > $model->amount ){
                    $transaction = Yii::$app->db->beginTransaction();
                    if( $model->save() && $modelIncome->save()){
                        $transaction->commit(); 
                    }else{
                        $transaction->rollback();
                    }
                    
    
                    if (isset($_GET['id'])){
                        return $this->redirect(['user/view', 'id' => $_GET['id']]);
                    }else{
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }else{
                    Yii::$app->session->setFlash('error',"<strong>Please check your Available Balance</strong>");
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
     * Updates an existing Withdrawal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Withdrawal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Withdrawal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Withdrawal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Withdrawal::findOne(['id' => $id])) !== null) {
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

        if($model->status == 'pending')
        {   
            $model->status = 'approved';
        }
        
        if ($model->save()) {
            if ($_GET['from']=='admin'){
                return $this->redirect(['user/index',]);
            }else{
                return $this->redirect(['user/view', 'id' => $_GET['from']]);
            }
         
        }
       
    }
}
