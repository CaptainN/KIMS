<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var app\models\Student $student
 * @var string $tab
 * @var string $divClass
 */

$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['/student/index']];
$this->params['breadcrumbs'][] = ['label' => $student->name, 'url' => ['/student/view', 'id' => $student->id]];
$this->params['breadcrumbs'][] = ['label' => 'Update', 'url' => ('general' === $tab ? null : ['/student/update', 'id' => $student->id])];
?>
<div class="<?= null === $divClass ? 'student-update' : $divClass ?>">

   <div class="form-group">
      <?= Html::a('General',
         Url::to(['/student/update', 'id' => $student->id]), [
         'class' => 'btn btn-' . ('general' === $tab ? 'primary' : 'default'),
         'icon' => 'list',
      ]); ?>
      <?= Html::a('Phones',
         Url::to(['/student-phone/index', 'studentId' => $student->id]), [
         'class' => 'btn btn-' . ('phone' === $tab ? 'primary' : 'default'),
         'icon' => 'phone-alt',
      ]); ?>
      <?= Html::a('Addresses',
         Url::to(['/student-address/index', 'studentId' => $student->id]), [
         'class' => 'btn btn-' . ('address' === $tab ? 'primary' : 'default'),
         'icon' => 'home',
      ]); ?>
      <?= Html::a('Affiliations',
         Url::to(['/affiliation/index', 'studentId' => $student->id]), [
         'class' => 'btn btn-' . ('affiliation' === $tab ? 'primary' : 'default'),
         'icon' => 'link',
      ]); ?>
      <?= Html::a('Promotions',
         Url::to(['/promotion/index', 'studentId' => $student->id]), [
         'class' => 'btn btn-' . ('promotion' === $tab ? 'primary' : 'default'),
         'icon' => 'certificate',
      ]); ?>
   </div>
   
   <h1><?= Html::encode($this->title) ?></h1>
   