<?php

use backend\models\Packages;
use backend\models\User;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use kartik\grid\GridView;


/** @var yii\web\View $this */
/** @var backend\models\User $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <?php
        // DetailView Attributes Configuration
        $attributes = [
            [
                'group'=>true,
                'label'=>'Account Information',
                'rowOptions'=>['class'=>'table-info']
            ],
            [
                'columns' => [
                    [
                        'attribute'=>'email', 
                        //'label'=>'Book #',
                        //'displayOnly'=>true,
                        //'valueColOptions'=>['style'=>'width:30%']
                    ],
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute'=>'username', 
                        'format'=>'raw', 
                        'value'=>'<kbd>'.$model->username.'</kbd>',
                        //'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                        
                    ],
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute'=>'password_hash', 
                        'label' => 'Password',
                        'format'=>'raw', 
                        'value'=>'<kbd>'.$model->password_hash.'</kbd>',
                        //'valueColOptions'=>['style'=>'width:30%'], 
                        'displayOnly'=>true
                        
                    ],
                ]
            ],
            [
                'group'=>true,
                'label'=>'Personal Information',
                'rowOptions'=>['class'=>'table-info'],
                //'groupOptions'=>['class'=>'text-center']
            ],   
            [
                'columns' => [
                    [
                        'attribute'=>'first_name', 
                        'format'=>'raw', 
                    
                    
                    ],
                    [
                        'attribute'=>'middle_name', 
                        'format'=>'raw', 
                        
                    
                    ],
                    [
                        'attribute'=>'last_name', 
                        'format'=>'raw',      
                    ],

                ],
            ],
            [
                'columns' => [
                    [
                        'attribute'=>'address', 
                        'format'=>'raw',   
                    ],
                ],
            ],
            [
                'columns' => [

                    [
                        'attribute'=>'birthdate', 
                        'format'=>'date',
                        'type'=>DetailView::INPUT_DATE,
                        'widgetOptions' => [
                            'pluginOptions'=>['format'=>'yyyy-mm-dd']
                        ],
                    ],
                    [
                        'attribute'=>'mobile', 
                        'format'=>'raw', 
                    ],
                    [
                        'attribute'=>'gender', 
                        'format'=>'raw',
                        'value'=>'<kbd>'.strtoUpper($model->gender).'</kbd>',  
                        'displayOnly'=>true    
                    ],

                ],
            ],
        ];

        echo DetailView::widget([
            'model'=>$model,
            'attributes'=>$attributes,
            'panel' => [
                'heading' => 'Affiliate ID: '.$model->id,
                'type' => DetailView::TYPE_SUCCESS,
            
            ],
            'buttons1' => '{update}'
        ]);
    ?>

</div>
</br>
<div class="user-index">

    <?= GridView::widget([
        'dataProvider'=> $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
                       'id',
                        [
                            'label' => 'Package Name',
                            'value' => function ($searchModel) {
                                $packages =  Packages::findOne(['id' => $searchModel->package_id]);
                                if($packages)
                                    return $packages->name;
                                
                            }
                        ],   
                        [
                            'label' => 'Package Price',
                            'value' => function ($searchModel) {
                                $packages =  Packages::findOne(['id' => $searchModel->package_id]);
                                if($packages)
                                  return $packages->price;
                            }
                        ],
                        [
                            'label' => 'Daily Share',
                            'value' => function ($searchModel) {
                                $packages =  Packages::findOne(['id' => $searchModel->package_id]);
                                if($packages)
                                  return $packages->daily_share;
                            }
                        ],
                        [
                            'label' => 'Selling Period',
                            'value' => function ($searchModel) {
                                $packages =  Packages::findOne(['id' => $searchModel->package_id]);
                                if($packages)
                                  return $packages->selling_period;
                            }
                        ],
                        [
                            'label' => 'Refferror',
                            'value' => function ($searchModel) {
                                $user =  User::findOne(['id' => $searchModel->refferor_id]);
                                if($user)
                                    return $user->first_name.' '.$user->last_name;
                            }
                        ],
                        [
                            'label' => 'Filling Date',
                            'value' => function ($searchModel) {
                                $filling_date = strtotime($searchModel->filling_date);
                                $newdt = date('M/d/Y',$filling_date);
                                return $newdt;
                            }
                        ],
                        'status',
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'dropdown' => false,
                            'dropdownOptions' => ['class' => 'float-right'],
                            'template' => '{update} {delete} {activate}',
                            'buttons' => [
                                //view button
                                'activate' => function ($url, $model) {
                                    return Html::a('<span class="fa fa-toggle-on"></span>', $url, []);
                                },
                            ],
                            'urlCreator' => function($action, $model, $key, $index) {
                                if ($action === 'update') {
                                    $url = Yii::$app->urlManager->createAbsoluteUrl(['member-package/update', 'id' => $model->id,'from' => $model->user_id]);
                                    return $url;
                                }elseif ($action === 'delete') {
                                    $url = Yii::$app->urlManager->createAbsoluteUrl(['member-package/delete', 'id' => $model->id,'from' => $model->user_id]);
                                    return $url;
                                }elseif ($action === 'activate') {
                                $url = Yii::$app->urlManager->createAbsoluteUrl(['member-package/activate', 'id' => $model->id,'from' => $model->user_id]);
                                return $url;
                            }
                             },
                            'headerOptions' => ['class' => 'kartik-sheet-style'],
                        ],
                                                                    
                    ],
        'pjax'=>true,
        'responsive'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fas fa-book"></i> Business Info</h3>',
            'before'=>Html::a('<i class="fas fa-plus"></i> Add Package', ['member-package/create','id'=>$model->id], ['class' => 'btn btn-success']),
            'type'=>'success',
        ],
    ]);?>
    
</div>
</br>
<div class="user-income">

    <?= GridView::widget([
        'dataProvider'=> $dataProvider3,
        //'filterModel' => $searchModel,
        'columns' => [
                       'id',
                       'amount',
                       'created_at',
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'dropdown' => false,
                            'dropdownOptions' => ['class' => 'float-right'],
                            'template' => '{update}',
                            'buttons' => [
                                //view button
                                'activate' => function ($url, $model) {
                                    return Html::a('<span class="fa fa-toggle-on"></span>', $url, []);
                                },
                            ],
                            'urlCreator' => function($action, $model, $key, $index) {
                                if ($action === 'update') {
                                    $url = Yii::$app->urlManager->createAbsoluteUrl(['members-income/update', 'id' => $model->id,'from' => $model->user_id]);
                                    return $url;
                                }
                             },
                            'headerOptions' => ['class' => 'kartik-sheet-style'],
                        ],
                                                                    
                    ],
        'pjax'=>true,
        'responsive'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fa fa-money"></i> Available Income:  ₱'.$searchModel3->getTotalIncome($model->id).'</h3>',
            'before'=>Html::a('<i class="fas fa-plus"></i> Add Income', ['members-income/create','id'=>$model->id], ['class' => 'btn btn-success']),
            'type'=>'success',
        ],
    ]);?>
    
</div>
</br>
<div class="user-withdrawal">

    <?= GridView::widget([
        'dataProvider'=> $dataProvider2,
        //'filterModel' => $searchModel,
        'columns' => [
                       'id',
                       'amount',
                       'status',
                       'created_at',
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
                                    $url = Yii::$app->urlManager->createAbsoluteUrl(['withdrawal/activate', 'id' => $model->id,'from' => $model->user_id]);
                                    return $url;
                                }
                             },
                            'headerOptions' => ['class' => 'kartik-sheet-style'],
                        ],
                                                                    
                    ],
        'pjax'=>true,
        'responsive'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fa fa-money"></i> Withrawal  </h3>',
            'before'=>Html::a('<i class="fas fa-plus"></i> Cashout', ['withdrawal/create','id'=>$model->id], ['class' => 'btn btn-success']),
            'type'=>'success',
        ],
    ]);?>
    
</div>
