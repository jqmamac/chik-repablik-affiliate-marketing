<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

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
