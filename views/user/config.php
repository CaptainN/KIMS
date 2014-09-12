<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\User $model
 * @var yii\widgets\ActiveForm $form
 */

$this->title = 'User Config: ' . $model->username;
$this->params['breadcrumbs'][] = 'Config';
?>
<div class="user-config">

   <h1><?= Html::encode($this->title) ?></h1>

   <div class="user-form">

      <?php $form = ActiveForm::begin(['action' => Url::to(['/user/config','id' => $model->id])]); ?>

      <?= $form->field($model, 'rowsPerPage')->dropDownList([
         '25' => '25',
         '38' => '38',
         '50' => '50',
         '75' => '75',
         '100' => '100',
         '150' => '150',
         '200' => '200',
         '250' => '250',
         '200' => '300',
         '400' => '400',
         '500' => '500',
      ]) ?>

      <div class="form-group">
         <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
      </div>

      <?php ActiveForm::end(); ?>

   </div>

</div>
