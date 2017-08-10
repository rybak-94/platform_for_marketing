<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Advertiser;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Offer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'offer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'advertiser_id')->dropDownList(ArrayHelper::map(
    Advertiser::find()->all(), 'id', 'advertiser_name')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
