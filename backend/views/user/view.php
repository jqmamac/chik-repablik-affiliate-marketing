<?php

use backend\models\Packages;
use backend\models\User;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use kartik\builder\Form;
use kartik\form\ActiveForm;
use kartik\builder\FormGrid;

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
                        [
                            'label' => 'Package Name',
                            'value' => function ($searchModel) {
                                $packages =  Packages::findOne(['id' => $searchModel->id]);
                                return $packages->name;
                            }
                        ],   
                        [
                            'label' => 'Package Price',
                            'value' => function ($searchModel) {
                                $packages =  Packages::findOne(['id' => $searchModel->id]);
                                return $packages->price;
                            }
                        ],
                        [
                            'label' => 'Refferror',
                            'value' => function ($searchModel) {
                                $user =  User::findOne(['id' => $searchModel->user_id]);
                                return $user->first_name.' '.$user->last_name;
                            }
                        ],
                        'filling_date',
                        'status'
                                                                    
                    ],
        'pjax'=>true,
        'responsive'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fas fa-business"></i> Business Info</h3>',
            'type'=>'success',
        ],
    ]);?>
    
    </br>
        <?php   Modal::begin([
                'title' => 'Add Package',
                'toggleButton' => ['label' => '<i class="fas fa-th-list"></i> Add Package', 'class' => 'btn btn-success'],
                'options' => ['tabindex' => false]
            ]); 
        ?>
        
        <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
            
                $user = ArrayHelper::map(User::find()->where(['status'=>'10'])->all(), 'id', 'first_name');
                array_walk($user, function(&$value, $key){
                    $value = $key.' -- '.$value;
                });

                echo FormGrid::widget([
                    'model'=>$searchModel,
                    'form'=>$form,
                    'autoGenerateColumns'=>true,
                    'rows'=>[
                        [
                            'attributes'=>[       // 2 column layout
                                'user_id'=>['type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>[$model->id => $model->username], 'options'=>['title'=>'User']],
                            ]
                        ],
                        [
                            'attributes'=>[
                                'package_id'=>['type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>ArrayHelper::map(Packages::find()->all(), 'id', 'name'), 'hint'=>'Type and select state'],
                           ]
                            ],
                        [
                            'attributes'=>[
                                'refferor_id'=>[
                                    'type'=>Form::INPUT_WIDGET, 
                                    'widgetClass'=>'kartik\select2\Select2', 
                                    'options' => [
                                        'data' => $user,  
                                    ],
                                    'allowClear' => true    
                                ]
                            ]
                        ],
                        [
                            'attributes'=>[
                                'filling_date'=>[
                                    'type'=>Form::INPUT_WIDGET, 
                                    'widgetClass'=>'\kartik\date\DatePicker', 
                                    'hint'=>'Enter filling date (mm/dd/yyyy)'],
                                ]
                        ],
                        [
                            'attributes'=>[       // 3 column layout
                    
                                'actions'=>[    // embed raw HTML content
                                    'type'=>Form::INPUT_RAW, 
                                    'value'=>  '<div style="text-align: left; margin-top: 20px">' . 
                                        Html::resetButton('Reset', ['class'=>'btn btn-secondary btn-default']) . ' ' .
                                        Html::submitButton('Submit', ['class' => 'btn btn-primary', 
                                            'value'=>'my_value', 'name'=>'submit',
                                            'onClick'=>'buttonClicked']) . 
                                        '</div>'
                                ],
                            ],
                        ],
                    ]
                    ]
                );
                ActiveForm::end(); 
            ?>
        
       <?php Modal::end(); ?>
</div>
