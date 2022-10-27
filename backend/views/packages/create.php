<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Packages $model */

$this->title = Yii::t('app', 'Create Package');

?>
<div class="packages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
