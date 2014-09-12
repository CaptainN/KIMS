<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use kartik\grid\GridView;
use yii\web\JsExpression;
use app\components\ToggleColumn;
use dosamigos\grid\EditableColumn;
use dosamigos\editable\Editable;
use app\models\Student;
use app\models\Division;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\StudentSearch $searchModel
 */
$dataProvider->pagination->pageSize = Yii::$app->user->rowsPerPage;

$this->registerJsFile('/js/student-index.js', ['\app\assets\AppAsset']);
$this->registerCssFile('/css/student-index.css', ['\app\assets\AppAsset']);

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
   ['class' => 'yii\grid\SerialColumn'],
   [
      'class' => ToggleColumn::className(),
      'attribute' => 'active',
      'filter' => ['1' => 'Y', '0' => 'N', '' => 'All'],
      'headerOptions' => ['style' => 'width:20px'],
      'contentOptions' => ['class' => 'text-center'],
   ],
   [
      'attribute' => 'gender',
      'class' => EditableColumn::className(), 'url' => 'editable',
      'contentOptions' => ['class' => 'text-center', 'nowrap' => true],
      'headerOptions' => ['class' => 'text-center', 'style' => 'width:20px'],
      'type' => 'select',
      'filter' => ['M' => 'M', 'F' => 'F', '' => 'All'],
      'editableOptions' => [
         'showbuttons' => false,
         'mode' => 'inline',
         'source' => '[{"M": "M"}, {"F": "F"}]',
         'value' => function($model)
        {
           return $model->gender;
        },
      ],
   ],
   [
      'attribute' => 'fname', 'contentOptions' => ['nowrap' => true],
      'class' => EditableColumn::className(), 'url' => 'editable',
      'editableOptions' => [
         'mode' => 'inline',
      ],
   ],
   [
      'attribute' => 'lname', 'contentOptions' => ['nowrap' => true],
      'class' => EditableColumn::className(), 'url' => 'editable',
      'editableOptions' => [
         'mode' => 'inline',
      ],
   ],
   [
      'value' => 'division.name',
      'header' => 'Div',
      'attribute' => 'division_id',
      'headerOptions' => ['class' => 'text-center', 'style' => 'width:20px'],
      'contentOptions' => ['class' => 'text-center'],
      'filter' => Division::getMap() + ['' => 'All'],
      'class' => EditableColumn::className(),
      'url' => 'editable',
      'type' => 'select',
      'editableOptions' => [
         'showbuttons' => false,
         'value' => function($model)
        {
           return $model->division_id;
        },
         'source' => Json::encode(Division::getMap()),
         'mode' => 'inline',
      ],
   ],
   [
      'value' => 'handAnchor.name',
      'attribute' => 'handAnchorId',
      'header' => 'Anchor',
      'headerOptions' => ['class' => 'text-center'],
      'contentOptions' => ['nowrap' => true],
      'class' => EditableColumn::className(), 'url' => 'editable',
      'type' => 'select',
      'editableOptions' => [
         'showbuttons' => false,
         'mode' => 'inline',
         'value' => function($model)
        {
           return $model->affiliation->hand_anchor_id;
        },
         'source' => function($model)
        {
           return Url::to(['/student/available-classes', 'id' => $model->id, 'type' => 'hand']);
        }
      ],
   ],
   [
      'value' => 'dobAndAge',
      'attribute' => 'dob',
      'header' => 'DoB & Age',
      'contentOptions' => ['nowrap' => true, 'style' => 'width:100px'],
      'class' => EditableColumn::className(), 'url' => 'editable',
      'type' => 'combodate',
      'editableOptions' => [
         //'mode' => 'inline',
         'value' => function($model)
        {
           return $model->dob;
        },
         'format' => 'YYYY-MM-DD',
         'viewformat' => 'M/D',
         'template' => 'M / D / YYYY',
      ],
   ],
   [
      'attribute' => 'belt_size',
      'headerOptions' => ['style' => 'width:20px'],
      'contentOptions' => ['class' => 'text-center'],
      'class' => EditableColumn::className(),
      'filter' => Student::getGiSizeMap() + ['' => 'All'],
      'url' => 'editable',
      'type' => 'select',
      'editableOptions' => [
         'mode' => 'inline',
         'showbuttons' => false,
         'value' => function($model)
        {
           return $model->belt_size;
        },
         'source' => Json::encode(Student::getGiSizeMap()),
      ],
   ],
   [
      'attribute' => 'bestPhoneNumber',
      'contentOptions' => ['nowrap' => true],
      'class' => EditableColumn::className(), 'url' => 'editable',
      'editableOptions' => [
         'mode' => 'inline',
      ],
   ],
   [
      'attribute' => 'sparAuth',
      'value' => 'sparAuthJson',
      'contentOptions' => ['class' => 'text-center'],
      'headerOptions' => ['style' => 'width:20px'],
      'class' => EditableColumn::className(), 'url' => 'editable',
      //'filter' => Student::getSparAuthList(), 
      'type' => 'checklist',
      'editableOptions' => [
         'value' => function($model)
        {
           return $model->sparAuthJson;
        },
         'display' => new JsExpression("function(value, sourceData)
         {  
            var icon = 'remove';
            //console.log(value, sourceData);
            if(value instanceof Array && value[0] !== '')
            {
               $.each(value, function(i, v)
               {
                  if (v.toLowerCase() === 'a')
                  {
                     icon = 'ok';
                     return false;
                  }
                  else
                  {
                     icon = 'tasks';
                  }
               });
            }
            $(this).html('<span class=\"glyphicon glyphicon-' + icon + '\"></span>');
        }"),
         'mode' => 'pop',
         'source' => Json::encode(Student::getSparAuthList()),
      ],
   ],
   [
      'attribute' => 'rank.name',
      'contentOptions' => ['nowrap' => true]
   ],
   [
      'attribute' => 'grappleAuth',
      'value' => 'grappleAuthJson',
      'contentOptions' => ['class' => 'text-center'],
      'headerOptions' => ['style' => 'width:20px'],
      'class' => EditableColumn::className(), 'url' => 'editable',
      'type' => 'checklist',
      'editableOptions' => [
         'value' => function($model)
        {
           return $model->grappleAuthJson;
        },
         'display' => new JsExpression("function(value, sourceData)
            {
               var icon = 'remove';
               //console.log(value, sourceData);
               if(value instanceof Array && value[0] !== '')
               {
                  $.each(value, function(i, v)
                  {
                     if (v.toLowerCase() === 'a')
                     {
                        icon = 'ok';
                        return false;
                     }
                     else
                     {
                     console.log(v);
                        icon = 'tasks';
                     }
                  });
               }
               $(this).html('<span class=\"glyphicon glyphicon-' + icon + '\"></span>');
            }"
         ),
         'mode' => 'pop',
         'source' => Json::encode(Student::getGrappleAuthList()),
      ],
   ],
   //weaponanchor
   [
      'class' => 'yii\grid\ActionColumn',
      'contentOptions' => ['nowrap' => true],
      'template' => '{view} {update}' . (Yii::$app->user->can('deleteStudent') ? ' {delete}' : ''),
   ],
];
?>
<div class="student-index">

   <h1><?= Html::encode($this->title) ?></h1>

   <?php //echo $this->render('_search', ['model' => $searchModel]);   ?>

   <p>
      <?= Html::a('Reset To Attendance Sort', ['index'], ['class' => 'btn btn-success']) ?>
      <?= Html::a('Create Student', ['create'], ['class' => 'btn btn-success']) ?>
      <?= Html::a('Not Authorized to Spar', ['/report/sparauth'], ['class' => 'btn btn-success']) ?>
      <?= Html::a('Create Attendance Sheet', ['/report/attendance'], ['class' => 'btn btn-success']) ?>
      <?= 'Report Month: ' .
      Editable::widget([
         'model' => Yii::$app->user->identity,
         'attribute' => 'reportMonth',
         'url' => '/user/editable',
         'type' => 'combodate',
         'clientOptions' => [
            'value' => Yii::$app->user->reportMonth,
            'viewformat' => 'MMM YYYY',
            'template' => 'MMM / YYYY',
            'format' => 'MMM YYYY',
         ],
      ]);
      ?>
   </p>

   <?php
   // calculate the total # of active contract students, plus guests
   $currentSchoolId = Yii::$app->user->schoolId;
   $contractStudents = $searchModel::find()
    ->where([
       'student.active' => 1,
       'contract_school_id' => $currentSchoolId,
    ])
    ->count()
   ;
   $guestStudents = $searchModel::find()
    ->joinWith('affiliations')
    ->where([
       'student.active' => 1,
       'affiliation.active' => 1,
       'affiliation.school_id' => $currentSchoolId,
    ])
    ->andWhere(['not in', 'contract_school_id', [$currentSchoolId]])
    ->count()
   ;
   echo sprintf('%d active contract students, plus %d guest%s', $contractStudents, $guestStudents, (int) $guestStudents === 1 ? '' : 's');
   ?>

   <?=
   GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => $columns,
   ]);
   ?>

</div>