<?php

use app\models\Countries;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Countries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="countries-form">

    <?= Html::csrfMetaTags() ?>
    <?php $form = ActiveForm::begin(); ?>

    <?php $countries = Countries::find()->select(['id','country_code','country_name'])->asArray()->all();?>


    <?php echo '<table class="table table-striped table-bordered">'; ?>
    <?php foreach($countries as $country){
        $model->id = $country['id'];
        $model->country_code = $country['country_code'];
        $model->country_name = $country['country_name'];
        echo '<tr>';
        echo '<td>' . $form->field($model, 'id')->textInput(['style'=>'width:100px', 'name'=> 'country_id[]']) . '</td>';
        echo '<td>' . $form->field($model, 'country_code')->textInput(['style'=>'width:100px', 'name'=> 'country_code[]']) . '</td>';
        echo '<td>' . $form->field($model, 'country_name')->textInput(['style'=>'width:100px', 'name'=> 'country_name[]']) . '</td>';
        echo '</tr>';
    } ?>
    <?php echo '</table>';?>


    <div class="form-group">
        <?=   Html::submitButton('update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
