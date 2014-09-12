<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\grid\ToggleColumn;
use dosamigos\grid\EditableColumn;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\SchoolSearch $searchModel
 */

$this->title = 'Schools';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create School', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            ['class' => ToggleColumn::className(),
             'attribute' => 'active',],
            'name',
            'abbr',
            'kai_template',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
