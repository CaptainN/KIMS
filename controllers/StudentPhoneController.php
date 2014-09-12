<?php

namespace app\controllers;

use Yii;
use app\models\Student;
use app\models\StudentPhone;
use app\models\search\StudentPhoneSearch;
use app\components\KimsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentPhoneController implements the CRUD actions for StudentPhone model.
 */
class StudentPhoneController extends KimsController
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
    * Lists all StudentPhone models.
    * @return mixed
    */
   public function actionIndex($studentId)
   {
      $student = Student::findOne($studentId);
      if (null === $student || !user()->can('printAttendance'))
      {
         setError('Access denied.');
         return $this->redirect(['/student/update', 'id' => $studentId]);
      }
      $searchModel = new StudentPhoneSearch;
      $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
      $dataProvider->query->andWhere(['student_id' => $studentId]);
      $dataProvider->pagination = false;

      return $this->render('index', [
          'student' => $student,
          'dataProvider' => $dataProvider,
          'searchModel' => $searchModel,
      ]);
   }

   /**
    * Displays a single StudentPhone model.
    * @param integer $id
    * @return mixed
    */
   public function actionView($id)
   {
      $model = $this->findModel($id);
      $studentId = $model->student_id;
      $student = Student::findOne($studentId);
      if (!user()->can('viewStudent', ['student' => $student]))
      {
         setError('Access denied.');
         return $this->redirect(['/student/index'], 403);
      }
      return $this->render('view', [
          'student' => $student,
          'model' => $model,
      ]);
   }

   /**
    * Creates a new StudentPhone model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
   public function actionCreate($studentId)
   {
      $student = Student::findOne($studentId);
      if (!user()->can('updateStudent', ['student' => $student]))
      {
         setError('Access denied.');
         return $this->redirect(['/student/view', 'id' => $studentId], 403);
      }

      $model = new StudentPhone;

      if ($model->load(Yii::$app->request->post()) && $model->save())
      {
         return $this->redirect(['view', 'id' => $model->id]);
      } else
      {
         return $this->render('create', [
             'student' => $student,
             'model' => $model,
         ]);
      }
   }

   /**
    * Updates an existing StudentPhone model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    */
   public function actionUpdate($id)
   {
      $model = $this->findModel($id);
      $studentId = $model->student_id;
      $student = Student::findOne($studentId);
      if (!user()->can('updateStudent', ['student' => $student]))
      {
         setError('Access denied.');
         return $this->redirect(['/student/view', 'id' => $studentId], 403);
      }

      if ($model->load(Yii::$app->request->post()) && $model->save())
      {
         return $this->redirect(['view', 'id' => $model->id]);
      } else
      {
         return $this->render('update', [
             'student' => $student,
             'model' => $model,
         ]);
      }
   }

   /**
    * Deletes an existing StudentPhone model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    */
   public function actionDelete($id)
   {
      $this->findModel($id)->delete();

      return $this->redirect(['index']);
   }

   /**
    * Finds the StudentPhone model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return StudentPhone the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id)
   {
      if (($model = StudentPhone::findOne($id)) !== null)
      {
         return $model;
      }
      else
      {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

}
