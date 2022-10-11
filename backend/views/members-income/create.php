<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\MembersIncome $model */

$this->title = Yii::t('app', 'Create Members Income');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Members Incomes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="members-income-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
