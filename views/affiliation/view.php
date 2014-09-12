<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\Affiliation $model
 */

$this->title = $model->id;
?>

<?= $this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'affiliation',
   'divClass' => 'affiliation-view',
]) ?>
<?php
$this->params['breadcrumbs'][] = ['label' => 'Affiliations', 'url' => ['index', 'studentId' => $student->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'active',
            'contract',
            'student_id',
            'school_id',
            'role_id',
            'hand_anchor_id',
            'weapon_anchor_id',
            'date',
        ],
    ]) ?>

</div>
<?= $this->render('/student/update-footer', []) ?>