<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Advertiser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertiser-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'advertiser_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pb_method')->dropDownList(['POST' => 'POST', 'GET' => 'GET']) ?>

    <?= $form->field($model, 'pb_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pbr_success')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'check_response')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
