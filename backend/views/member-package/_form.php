<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\builder\Form;
use kartik\form\ActiveForm;
use kartik\builder\FormGrid;

use backend\models\User;
use backend\models\Packages;


/** @var yii\web\View $this */
/** @var backend\models\MemberPackage $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="member-package-form">

<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
            
            $user = ArrayHelper::map(User::find()->where(['status'=>'10'])->all(), 'id', 'first_name');
            array_walk($user, function(&$value, $key){
                $value = $key.' -- '.$value;
            });
            echo FormGrid::widget([
                'model'=>$model,
                'form'=>$form,
                'autoGenerateColumns'=>true,
                'rows'=>[
                    [
                        'attributes'=>[
                            'user_id'=>[
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
                                    Html::submitButton('Submit', ['class' => 'btn btn-primary']) . 
                                    '</div>'
                            ],
                        ],
                    ],
                ]
                ]
            );
            ActiveForm::end(); 
        ?>

</div>
