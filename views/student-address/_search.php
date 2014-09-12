<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\search\StudentAddressSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="student-address-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'student_id') ?>

    <?= $form->field($model, 'line1') ?>

    <?= $form->field($model, 'line2') ?>

    <?= $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'state_abbr') ?>

    <?php // echo $form->field($model, 'zip') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'ord') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
