<?php

use app\models\Offer;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Macros */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="macros-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $request = Yii::$app->request;
    if ($request->get('offer_id')){
        $offer_id = $request->get('offer_id');
        $model->offer_id=$offer_id;
    }
    else {
        $model->offer_id=0;
    }
    ?>

     <?= $form->field($model, 'offer_id')->dropDownList(ArrayHelper::map(
        Offer::find()->all(), 'id', 'id')) ?>

    <?= $form->field($model, 'token_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'token_value')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
  <?=   Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
