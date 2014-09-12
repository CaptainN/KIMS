<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\AClass $model
 */

$this->title = 'Create Class';
$this->params['breadcrumbs'][] = ['label' => 'Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aclass-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
