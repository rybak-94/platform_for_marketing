<?php

use app\models\Offer;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MacrosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\Macros */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Macros';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="macros-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>




    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'offer_id',
            'token_key',
            'token_value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
