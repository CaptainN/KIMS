<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var \app\models\Student[] $models
 * @var string $lname
 */
// display no warning if there are no results
$this->registerJsFile('/js/name-conflict.js');
$modelCount = count($models);
if (0 === $modelCount)
   return '';
?>
<div class="name-conflict">
   <h4>Please ensure you are not re-entering
      <?= $modelCount !== 1 ? 'one of these students' : 'this student' ?>:
   </h4>
   <?php
   $html = [];
   foreach ($models as $k => $v)
   {
      $html [] = '<div>';
      $html [] = Html::a($v->name, Url::to(['student/update', 'id' => $v->id]));
      $html [] = ' - ';
      $html [] = $v->contractSchool->name;
      $html [] = ' (';
      //!!! TODO: make the active toggle editable
      /*$html []= Html::a(boolval($v->active) ? 'Active' : 'Inactive',
        Url::to(['student/toggle', 'attribute' => 'active', 'id' => $v->id]), ['class' => 'active_toggle', 'data-method' => 'post']);*/
      $html [] = boolval($v->active) ? 'Active' : 'Inactive';
      $html [] = ')';
      $html [] = '</div>';
   }
   echo join('', $html);
   ?>
</div>