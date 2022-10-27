<?php

use backend\models\Withdrawal;
use backend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
/** @var yii\web\View $this */
/** @var backend\models\WithdrawalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Withdrawals History');
?>
<div class="withdrawal-index">
    
    <?= GridView::widget([
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                       'user_id',
                        [
                            'label' => 'Affiliate Name',
                            'filter' => ['name'],
                            'value' => function ($model) {
                                $user =  User::findOne(['id' => $model->user_id]);
                                if($user)
                                    return $user->first_name.' '.$user->last_name;
                            },
                            'vAlign' => 'middle',
                            'hAlign' => 'middle', 
                        ],
                        'created_at',
                        [
                            'attribute'=>'status',
                            'header'=>'Status',
                            'filter' => ['pending'=>'Pending', 'approved'=>'Approved'],
                            'format'=>'raw',    
                            'value' => function($model, $key, $index)
                            {   
                                if($model->status == 'pending')
                                {
                                    return '<button class="btn green">Pending</button>';
                                }
                                else
                                {   
                                    return '<button class="btn red">Approved</button>';
                                }
                            },
                        ],
                        [
                            'attribute' => 'amount', 
                            'vAlign' => 'middle',
                            'hAlign' => 'right', 
                            'width' => '7%',
                            'format' => ['decimal', 2],
                            'pageSummary' => true
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'dropdown' => false,
                            'dropdownOptions' => ['class' => 'float-right'],
                            'template' => '{activate}',
                            'buttons' => [
                                //view button
                                'activate' => function ($url, $model) {
                                    return Html::a('<span class="fa fa-toggle-on"></span>', $url, []);
                                },
                            ],
                            'urlCreator' => function($action, $model, $key, $index) {
                                if ($action === 'activate') {
                                    $url = Yii::$app->urlManager->createAbsoluteUrl(['withdrawal/activate', 'id' => $model->id,'from' => 'admin', 'user_id' => $model->user_id]);
                                    return $url;
                                }
                             },
                            'headerOptions' => ['class' => 'kartik-sheet-style'],
                        ],
                                                                    
                    ],
        'pjax'=>true,
        'responsive'=>true,
        'responsiveWrap' =>true,
        'showPageSummary' => true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fas fa-history"></i> Withrawal Transaction  </h3>',
            //'before'=>Html::a('<i class="fas fa-book"></i> Show Withdrawal Transaction', ['withdrawal/index','id'=>$searchModel2->id], ['class' => 'btn btn-success']),
            'type'=>'success',
        ],
    ]);?>
    

</div>
