<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\StudentSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="student-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fname') ?>

    <?= $form->field($model, 'mname') ?>

    <?= $form->field($model, 'lname') ?>

    <?= $form->field($model, 'division_id') ?>

    <?php // echo $form->field($model, 'kai_number') ?>

    <?php // echo $form->field($model, 'belt_size') ?>

    <?php // echo $form->field($model, 'gi_size') ?>

    <?php // echo $form->field($model, 'dob') ?>

    <?php echo $form->field($model, 'anchor.name') ?>

    <?php // echo $form->field($model, 'weapon_anchor_id') ?>

    <?php // echo $form->field($model, 'contract_school_id') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'notes') ?>

    <?php // echo $form->field($model, 'spar_auth') ?>

    <?php // echo $form->field($model, 'grapple_auth') ?>

    <?php // echo $form->field($model, 'prefix') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
