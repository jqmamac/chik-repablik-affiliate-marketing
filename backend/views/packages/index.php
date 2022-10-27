<?php

use backend\models\Packages;
use backend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
//use yii\grid\GridView;
use yii\widgets\Pjax;

use kartik\grid\GridView;
/** @var yii\web\View $this */
/** @var backend\models\PackagesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Package Manager');
?>
<div class="packages-index">

    <?= GridView::widget([
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                       'name',
                        [
                            'attribute' => 'price', 
                            'vAlign' => 'middle',
                            'hAlign' => 'right', 
                            'width' => '7%',
                            'format' => ['decimal', 2],
                            //'pageSummary' => true
                        ],
                        [
                            'attribute' => 'daily_share', 
                            'vAlign' => 'middle',
                            'hAlign' => 'right', 
                            'width' => '7%',
                            'format' => ['decimal', 2],
                            //'pageSummary' => true
                        ],
                        [
                            'attribute' => 'weekly_withdrawal', 
                            'vAlign' => 'middle',
                            'hAlign' => 'right', 
                            'width' => '7%',
                            'format' => ['decimal', 2],
                            //'pageSummary' => true
                        ],
                        [
                            'attribute' => 'selling_period', 
                            'vAlign' => 'middle',
                            'hAlign' => 'right', 
                            'width' => '7%',
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'dropdown' => false,
                            'dropdownOptions' => ['class' => 'float-right'],
                            'template' => '{update} {delete}',
                            // 'buttons' => [
                            //     //view button
                            //     'activate' => function ($url, $model) {
                            //         return Html::a('<span class="fa fa-toggle-on"></span>', $url, []);
                            //     },
                            // ],
                            // 'urlCreator' => function($action, $model, $key, $index) {
                            //     if ($action === 'activate') {
                            //         $url = Yii::$app->urlManager->createAbsoluteUrl(['withdrawal/activate', 'id' => $model->id,'from' => 'admin', 'user_id' => $model->user_id]);
                            //         return $url;
                            //     }
                            //  },
                            'headerOptions' => ['class' => 'kartik-sheet-style'],
                        ],
                                                                    
                    ],
        'pjax'=>true,
        'responsive'=>true,
        'responsiveWrap' =>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fas fa-history"></i> Package Manager  </h3>',
            'before'=>Html::a('<i class="fas fa-plus"></i> Create Packages', ['packages/create'], ['class' => 'btn btn-success']),
            'type'=>'success',
        ],
    ]);?>
    

</div>
