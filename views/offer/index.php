<?php

use app\models\Payout;
use app\models\Offer;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OfferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Offers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Offer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php

    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'offer_name',
            [
                'attribute'=>'advertiser',
                'value' => 'advertiser.advertiser_name'
            ],
//            [
//                'label' => 'Token key',
//                'format' => 'html',
//                'value' => function($data) {
//                    return $data->getItemTokenKey();
//                }
//            ],
//            [
//                'label' => 'Token value',
//                'format' => 'html',
//                'value' => function($data) {
//                    return $data->getItemTokenValue();
//                }
//            ],

            ['class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['width' => '80'],
                'header'=>'Actions',
            'template' => "{view} {update}\n {delete}<hr> \n{macrosCreate} \n 
            {macrosUpdate}",
                'buttons' => [
//                    'payoutCreate' => function ($url,$model,$key) {
//                            //Create url to payout/create
//                        $url=Url::toRoute(['payout/create','offer_id'=>$model['id']]);
//                        return Html::a('Add Pay', $url);
//                    },
                    'macrosCreate' => function ($url,$model,$key) {
                        //Create url to macros/create
                        $url=Url::toRoute(['macros/create','offer_id'=>$model['id']]);
                        return Html::a('Add Mac', $url);
                    },
                    'macrosUpdate' => function ($url,$model,$key) {
                        //Create url to macros/create
                        //['macros/update','offer_id'=>$model['id']]
                        $url=Url::toRoute(['macros/upall', 'offer_id'=>$model['id']]);
                        return Html::a('Edit Mac', $url);
                    },
//                    'payoutUpdate' => function ($url,$model,$key) {
//                        //Create url to macros/create
//                        //['macros/update','offer_id'=>$model['id']]
//                        $url=Url::toRoute(['payout/upall', 'offer_id'=>$model['id']]);
//                        return Html::a('Edit Pay', $url);
//                    },
                ],
            ],
        ],
    ]); ?>
</div>
