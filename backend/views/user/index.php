<?php

use backend\models\MembersIncome;
use backend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Administrator Dashboard');

?>

<h1><?= Html::encode($this->title) ?></h1>
</br>
<div class="user-index">

    <?= GridView::widget([
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                        'id',
                        'first_name',
                        'last_name',
                        [
                            'attribute'=>'status',
                            'header'=>'Status',
                            'filter' => ['10'=>'Active', '9'=>'Inactive'],
                            'format'=>'raw',    
                            'value' => function($model, $key, $index)
                            {   
                                if($model->status == '10')
                                {
                                    return '<button class="btn green">Active</button>';
                                }
                                else
                                {   
                                    return '<button class="btn red">Inactive</button>';
                                }
                            },
                        ],
                        [
                            'label' => 'Wallet Balance',
                            'value' => function ($model) {
                                $user =  $model->getTotalIncome($model->id);
                                if ($user) {
                                    return $user;
                                }else{
                                    return 0;
                                }
                                
                            },
                            'vAlign' => 'middle',
                            'hAlign' => 'right', 
                            'width' => '7%',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                        ],
                        [
                            'label' => 'Accumulated Income',
                            'value' => function ($model) {
                                $user =  $model->getTotalIncomeOnly($model->id);
                                if ($user) {
                                    return $user;
                                }else{
                                    return 0;
                                }
                                
                            },
                            'vAlign' => 'middle',
                            'hAlign' => 'right', 
                            'width' => '7%',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'dropdown' => false,
                            'dropdownOptions' => ['class' => 'float-right'],
                            'template' => '{view}  {activate} {delete} {income}',
                            'buttons' => [
                                //view button
                                'activate' => function ($url, $model) {
                                    return Html::a('<span class="fa fa-toggle-on"></span>', $url, []);
                                },
                                'income' => function ($url, $model) {
                                    return Html::a('<span class="fa fa-money-bill"></span>', $url, []);
                                },
                                
                            ],
                            'urlCreator' => function($action, $model, $key, $index) {
                                if ($action === 'view') {
                                    $url = Yii::$app->urlManager->createAbsoluteUrl(['user/view', 'id' => $model->id]);
                                    return $url;
                                }elseif ($action === 'delete') {
                                    $url = Yii::$app->urlManager->createAbsoluteUrl(['user/delete', 'id' => $model->id]);
                                    return $url;
                                }elseif ($action === 'activate') {
                                    $url = Yii::$app->urlManager->createAbsoluteUrl(['user/activate', 'id' => $model->id]);
                                    return $url;
                                }elseif ($action === 'income') {
                                    $url = Yii::$app->urlManager->createAbsoluteUrl(['members-income/create', 'id' => $model->id]);
                                    return $url;
                                }
                             },
                            'headerOptions' => ['class' => 'kartik-sheet-style'],
                        ],             
                                
                    ],
        'pjax'=>true,
        'responsive'=>true,
        'responsiveWrap' =>false,
        'showPageSummary' => true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fas fa-user"></i> Affiliate List</h3>',
            'type'=>'success',
            'before'=>Html::a('<i class="fas fa-plus"></i> Create Affiliate', Yii::$app->urlManagerFrontEnd->createUrl('site/signup'), ['class' => 'btn btn-success']),
            //'after'=>Html::a('<i class="fas fa-redo"></i> Reset Grid', ['index'], ['class' => 'btn btn-warning']),
            //'footer'=>true
        ],
    ]);?>

</div>
</br>
<div class="admin-withdrawal">

   <?= GridView::widget([
        'dataProvider'=> $dataProvider2,
        //'filterModel' => $searchModel2,
        'columns' => [
                       'id',
                        [
                            'label' => 'Affiliate',
                            'value' => function ($model) {
                                $user =  User::findOne(['id' => $model->user_id]);
                                if($user)
                                    return $user->first_name.' '.$user->last_name;
                            }
                        ],
                        'created_at',
                        'status',
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
        'responsiveWrap' =>false,
        'showPageSummary' => true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fa fa-money"></i> Withrawal Request  </h3>',
            'before'=>Html::a('<i class="fas fa-book"></i> Show Withdrawal Transaction', ['withdrawal/index','id'=>$searchModel2->id], ['class' => 'btn btn-success']),
            'type'=>'success',
        ],
    ]);?>
    
</div>
