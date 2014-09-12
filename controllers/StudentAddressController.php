<?php

namespace app\controllers;

use Yii;
use app\models\Student;
use app\models\StudentAddress;
use app\models\search\StudentAddressSearch;
use app\components\KimsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentAddressController implements the CRUD actions for StudentAddress model.
 */
class StudentAddressController extends KimsController
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

   /**
    * Lists all StudentAddress models.
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
      $searchModel = new StudentAddressSearch;
      $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
      $dataProvider->query->where(['student_id' => $studentId]);
      $dataProvider->query->orderBy(['ord' => SORT_DESC]);
      return $this->render('index', [
          'student' => $student,
          'dataProvider' => $dataProvider,
          'searchModel' => $searchModel,
      ]);
   }

   /**
    * Displays a single StudentAddress model.
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
    * Creates a new StudentAddress model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
   public function actionCreate($studentId)
   {
      $model = new StudentAddress;
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
    * Updates an existing StudentAddress model.
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
    * Deletes an existing StudentAddress model.
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
    * Finds the StudentAddress model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return StudentAddress the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id)
   {
      if (($model = StudentAddress::findOne($id)) !== null)
      {
         return $model;
      } else
      {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

}
