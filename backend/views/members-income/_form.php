<?php

use yii\helpers\Html;
use kartik\builder\Form;
use kartik\form\ActiveForm;
use kartik\builder\FormGrid;

/** @var yii\web\View $this */
/** @var backend\models\MembersIncome $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="members-income-form">

<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
            
            echo FormGrid::widget([
                'model'=>$model,
                'form'=>$form,
                'autoGenerateColumns'=>true,
                'rows'=>[
                    [
                        'attributes'=>[
                            'amount'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Amount']],
                       ]
                    ],
                    [
                        'attributes'=>[
                            'note'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Note...']],
                       ]
                    ],
                    [
                        'attributes'=>[       // 3 column layout
                
                            'actions'=>[    // embed raw HTML content
                                'type'=>Form::INPUT_RAW, 
                                'value'=>  '<div style="text-align: left; margin-top: 20px">' . 
                                    //Html::resetButton('Reset', ['class'=>'btn btn-secondary btn-default']) . ' ' .
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
