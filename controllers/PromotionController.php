<?php

namespace app\controllers;

use Yii;
use \app\models\Promotion;
use \app\models\search\PromotionSearch;
use \app\models\Student;
use \yii\web\NotFoundHttpException;
use \yii\filters\VerbFilter;

/**
 * PromotionController implements the CRUD actions for Promotion model.
 */
class PromotionController extends \app\components\KimsController
{

   public function behaviors()
   {
      return [
         'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
               'delete' => ['post'],
            ],
         ],
      ];
   }
   
   public function actionToggle($id, $attribute)
   {
      $model = $this->findModel($id);
      $studentId = $model->student_id;
      $student = Student::findOne($studentId);
      if (Yii::$app->user->can('updateStudent', ['student' => $student]))
      {
         $action = new ToggleAction('toggle', $this, [
            'modelClass' => Promotion::className(),
         ]);
         return $action->run($id, $attribute);
      }
   }

   /**
    * Lists all Promotion models.
    * @return mixed
    */
   public function actionIndex($studentId)
   {
      $student = Student::findOne($studentId);
      if (!Yii::$app->user->can('viewStudent', ['student' => $student]))
      {
         Yii::$app->session->setFlash('error', 'Access denied.');
         return $this->redirect(['/student/index'], 403);
      }
      $searchModel = new PromotionSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
      $dataProvider->query->where(['student_id' => $studentId]);
      $dataProvider->pagination = false;
      return $this->render('index', [
          'student' => $student,
          'dataProvider' => $dataProvider,
          'searchModel' => $searchModel,
      ]);
   }

   /**
    * Displays a single Promotion model.
    * @param integer $id
    * @return mixed
    */
   public function actionView($id)
   {
      $model = $this->findModel($id);
      $studentId = $model->student_id;
      $student = Student::findOne($studentId);
      if (!Yii::$app->user->can('viewStudent', ['student' => $student]))
      {
         Yii::$app->session->setFlash('error', 'Access denied.');
         return $this->redirect(['/student/index'], 403);
      }
      return $this->render('view', [
          'student' => $student,
          'model' => $model,
      ]);
   }

   /**
    * Creates a new Promotion model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
   public function actionCreate($studentId)
   {
      $model = new Promotion;
      $student = Student::findOne($studentId);
      if (!Yii::$app->user->can('updateStudent', ['student' => $student]))
      {
         Yii::$app->session->setFlash('error', 'Access denied.');
         return $this->redirect(['/student/index'], 403);
      }
      if ($model->load(Yii::$app->request->post()) && $model->save())
      {
         return $this->redirect(['index', 'studentId' => $studentId]);
      } else
      {
         return $this->render('create', [
             'student' => $student,
             'model' => $model,
         ]);
      }
   }

   /**
    * Updates an existing Promotion model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    */
   public function actionUpdate($id)
   {
      $model = $this->findModel($id);
      $studentId = $model->student_id;
      $student = Student::findOne($studentId);
      if (!Yii::$app->user->can('updateStudent', ['student' => $student]))
      {
         Yii::$app->session->setFlash('error', 'Access denied.');
         return $this->redirect(['/student/index'], 403);
      }
      if ($model->load(Yii::$app->request->post()) && $model->save())
      {
         return $this->redirect(['index', 'studentId' => $studentId]);
      } else
      {
         return $this->render('update', [
             'student' => $student,
             'model' => $model,
         ]);
      }
   }

   /**
    * Deletes an existing Promotion model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    */
   public function actionDelete($id)
   {
      $model = $this->findModel($id);
      $studentId = $model->student_id;
      $student = Student::findOne($studentId);
      if (!Yii::$app->user->can('updateStudent', ['student' => $student]))
      {
         Yii::$app->session->setFlash('error', 'Access denied.');
         return $this->redirect(['/student/index'], 403);
      }
      $model->delete();
      return $this->redirect(['index', 'studentId' => $studentId]);
   }

   /**
    * Finds the Promotion model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return Promotion the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id)
   {
      if (($model = Promotion::findOne($id)) !== null)
      {
         return $model;
      } else
      {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

}
