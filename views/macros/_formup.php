<?php

use app\models\Offer;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Macros */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="macros-form">

    <?= Html::csrfMetaTags() ?>
    <?php $form = ActiveForm::begin(); ?>

    <?php
    $request = Yii::$app->request;

    if ($request->get('offer_id')){
        $offer_id = $request->get('offer_id');
        $model->offer_id=$offer_id;
    }
    else {
        $model->offer_id=1;
    }
    ?>

    <?php $macs = \app\models\Macros::find()
        ->select(['token_value', 'token_key', 'id'])->from('macros')
        ->where(['offer_id'=> $_GET['offer_id']])->asArray()->all(); ?>

    <?php echo '<table class="table table-striped table-bordered">'; ?>
    <?php foreach($macs as $mac){
        $model->id = $mac['id'];
        $model->token_key = $mac['token_key'];
        $model->token_value = $mac['token_value'];
        echo '<tr>';
        echo '<td>' . $form->field($model, 'id')->textInput(['style'=>'width:100px','readonly' => true, 'name'=> 'token_id[]']) . '</td>';
        echo '<td>' . $form->field($model, 'token_key')->textInput(['style'=>'width:250px', 'name'=> 'token_key[]']) . '</td>';
        echo '<td>' . $form->field($model, 'token_value')->textInput(['style'=>'width:250px', 'name'=> 'token_value[]']) . '</td>';
        echo '<td>' . Html::a('delete', ['macros/delete', 'id' => $model->id], ['class' => 'btn btn-primary' , 'data-method' => 'post']) . '</td>';
        echo '</tr>';
    } ?>
    <?php echo '</table>';?>


    <div class="form-group">
        <?=   Html::submitButton('upall', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>