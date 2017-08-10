<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['contentOptions'=>['style'=>'white-space: pre-line; max-width:400px;'],
                'attribute'=>'message',
                'label' => 'Message',
                'value'=> 'message',
            ],
//            ['contentOptions'=>['style'=>'white-space: pre-line; max-width:400px;'],
//                'attribute'=>'data',
//                'label' => 'data',
//                'value'=> 'data',
//            ],
            [
                'attribute'=>'data',
                'contentOptions'=>['style'=>'white-space: pre-line; max-width:400px;'],
                'content'=>function($model){
                    return $model->data;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
