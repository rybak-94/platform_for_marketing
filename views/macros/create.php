<?php

use app\models\Macros;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Macros */
/* @var $macros app\models\Macros */

$url = Url::to('');

if (array_key_exists('offer_id', $_GET)){
    $offer_id = $_GET['offer_id'];

    $macros = Macros::find()->select(['offer_name'])
        ->leftJoin('offer', '`macros`.`offer_id` = `offer`.`id`')
        ->where(['offer_id' => $_GET['offer_id']])->asArray()->one();
}
else{
    $macros['offer_name'] = "";
}

//$macros = new \app\models\Macros();
//$macros->getOfferName();

$this->title = 'Create Macros' . " " . $macros['offer_name'] ;
$this->params['breadcrumbs'][] = ['label' => 'Offers', 'url' => ['offer/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="macros-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
