<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\search\AffiliationSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="affiliation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'active') ?>

    <?= $form->field($model, 'contract') ?>

    <?= $form->field($model, 'student_id') ?>

    <?= $form->field($model, 'school_id') ?>

    <?php echo $form->field($model, 'role_id') ?>

    <?php echo $form->field($model, 'hand_anchor_id') ?>

    <?php echo $form->field($model, 'weapon_anchor_id') ?>

    <?php echo $form->field($model, 'start_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
