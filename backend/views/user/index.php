<?php

use backend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?= GridView::widget([
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                        'id',
                        'first_name',
                        'last_name',
                        [
                            'attribute'=>'status',
                            'header'=>'Status',
                            'filter' => ['10'=>'Active', '9'=>'Inactive'],
                            'format'=>'raw',    
                            'value' => function($model, $key, $index)
                            {   
                                if($model->status == '10')
                                {
                                    return '<button class="btn green">Active</button>';
                                }
                                else
                                {   
                                    return '<button class="btn red">Inactive</button>';
                                }
                            },
                        ],
                        [
                            'header'=>'Action',
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {delete} {activate}',
                          
                        ],               
                                
                    ],
        'pjax'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fas fa-user"></i> User</h3>',
            'type'=>'success',
            'before'=>Html::a('<i class="fas fa-plus"></i> Create User', Yii::$app->urlManagerFrontEnd->createUrl('site/signup'), ['class' => 'btn btn-success']),
            'after'=>Html::a('<i class="fas fa-redo"></i> Reset Grid', ['index'], ['class' => 'btn btn-warning']),
            //'footer'=>true
        ],
    ]);?>

</div>
