<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdvertiserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertiser-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'advertiser_name') ?>

    <?= $form->field($model, 'pb_method') ?>

    <?= $form->field($model, 'pb_url') ?>

    <?= $form->field($model, 'pbr_success') ?>

    <?= $form->field($model, 'check_response') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
