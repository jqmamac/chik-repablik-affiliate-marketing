<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\MemberPackage $model */

$this->title = Yii::t('app', 'Create Member Package');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Member Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-package-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
