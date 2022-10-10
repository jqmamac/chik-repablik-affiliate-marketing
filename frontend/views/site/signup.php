<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use backend\models\Packages;
use yii\bootstrap5\Html;
//use yii\bootstrap5\ActiveForm;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use yii\helpers\ArrayHelper;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
                echo FormGrid::widget([
                    'model'=>$model,
                    'form'=>$form,
                    'autoGenerateColumns'=>true,
                    'rows'=>[
                        [
                            'contentBefore'=>'<legend class="text-info"><small>Account Info</small></legend>',
                            'attributes'=>[       // 2 column layout
                                'email'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter username...']],
                                'username'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter username...']],
                                'password'=>['type'=>Form::INPUT_PASSWORD, 'options'=>['placeholder'=>'Enter password...']],
                            ]
                        ],
                        [
                            'contentBefore'=>'<legend class="text-info"><small>Personal Info</small></legend>',
                            'attributes'=>[       // 2 column layout
                                'first_name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter first name...']],
                                'middle_name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter middle name...']],
                                'last_name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter last name...']],
                            ]
                        ],                   
                        [
                            'columns'=>3,
                            'autoGenerateColumns'=>false, // override columns setting
                            'attributes'=>[       // colspan example with nested attributes
                                'address_detail' => [ 
                                    'label'=>'Address',
                                    'labelOptions' => ['class' => 'is-required'], // displays the required asterisk
                                    'columns'=>6,
                                    'attributes'=>[
                                        'address'=>[
                                            'type'=>Form::INPUT_TEXTAREA, 
                                            'options'=>['placeholder'=>'Enter address...'],
                                            'columnOptions'=>['colspan'=>3],
                                        ],
                                    ]
                                ]
                            ],
                        ],
                        [
                            'attributes'=>[
                                'birthdate'=>[
                                    'type'=>Form::INPUT_WIDGET, 
                                    'widgetClass'=>'\kartik\date\DatePicker', 
                                    'hint'=>'Enter birthday (mm/dd/yyyy)'],
                                'mobile'=>[
                                    'label'=> 'Mobile',
                                    'type'=>Form::INPUT_TEXT, 
                                    'options'=>['placeholder'=>'Phone...']
                                ],
                                'gender'=>[
                                    'label'=>'Gender', 
                                    'items'=>['male'=>'Male', 'female'=>'Female'], 
                                    'type'=>Form::INPUT_RADIO_BUTTON_GROUP,
                                ],
                                ]
                        ],
                        [
                            'attributes'=>[       // 3 column layout
                    
                                'actions'=>[    // embed raw HTML content
                                    'type'=>Form::INPUT_RAW, 
                                    'value'=>  '<div style="text-align: left; margin-top: 20px">' . 
                                        Html::resetButton('Reset', ['class'=>'btn btn-secondary btn-default']) . ' ' .
                                        Html::submitButton('Submit', ['class'=>'btn btn-primary']) . 
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
    </div>
</div>
