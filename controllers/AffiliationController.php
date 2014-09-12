<?php

namespace app\controllers;

use Yii;
use app\models\Affiliation;
use app\models\search\AffiliationSearch;
use app\models\Student;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use dosamigos\grid\ToggleAction;

/**
 * AffiliationController implements the CRUD actions for Affiliation model.
 */
class AffiliationController extends \app\components\KimsController
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
            'modelClass' => Affiliation::className(),
         ]);
         return $action->run($id, $attribute);
      }
   }

   /**
    * Lists all Affiliation models.
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
      $searchModel = new AffiliationSearch;
      $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
      $dataProvider->query->where(['student_id' => $studentId]);
      return $this->render('index', [
          'student' => $student,
          'dataProvider' => $dataProvider,
          'searchModel' => $searchModel,
      ]);
   }

   /**
    * Displays a single Affiliation model.
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
    * Creates a new Affiliation model.
    * If creation is successful, the browser will be redirected to the 'index' page.
    * @return mixed
    */
   public function actionCreate($studentId)
   {
      $model = new Affiliation;
      $student = Student::findOne($studentId);
      if (!Yii::$app->user->can('updateStudent', ['student' => $student]))
      {
         Yii::$app->session->setFlash('error', 'Access denied.');
         return $this->redirect(['/student/index'], 403);
      }
      
      $model->date = date('Y-m-d');
      
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
    * Updates an existing Affiliation model.
    * If update is successful, the browser will be redirected to the 'index' page.
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
    * Deletes an existing Affiliation model.
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
    * Finds the Affiliation model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return Affiliation the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id)
   {
      if (($model = Affiliation::findOne($id)) !== null)
      {
         return $model;
      } else
      {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

}
