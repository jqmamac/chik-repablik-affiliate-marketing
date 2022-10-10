<?php

//use yii\helpers\Html;
//use yii\widgets\ActiveForm;

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Packages $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="packages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'daily_share')->textInput() ?>

    <?= $form->field($model, 'selling_period')->textInput() ?>

    <?= $form->field($model, 'weekly_withdrawal')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
