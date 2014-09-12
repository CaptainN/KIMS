<?php

namespace app\controllers;

use Yii;
use app\models\AClass;
use app\models\search\ClassSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\helpers\Json;

/**
 * ClassController implements the CRUD actions for AClass model.
 */
class ClassController extends \app\components\KimsController
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
    * @return string JSON used to fill a select box.
    */
   public function actionCreateStudentHandAnchors($division_id)
   {
      $query = AClass::find()
       ->joinWith('school')
       ->joinWith('divisions')
       ->joinWith('day')
       ->where([
          'location_id' => Yii::$app->user->school->id,
          'division_id' => $division_id,
          'type_id' => 1,
        ])
       ->orderBy(['-`day`.`ord`' => SORT_DESC, 'start_time' => SORT_ASC])
      ;

      $models = $query->all();
      $data = [];
      foreach ($models as $m)
      {
         $data[] = ['value' => $m->id, 'text' => $m->fullName];
      }
      return Json::encode($data);
   }

   /**
    * Lists all AClass models.
    * @return mixed
    */
   public function actionIndex()
   {
      $searchModel = new ClassSearch;
      $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

      if (Yii::$app->request->isAjax)
      {
         $models = $dataProvider->query->all();
         $data = [];
         foreach ($models as $m)
         {
            $data[] = [$m->id => $m->name];
         }
         return json_encode($data);
      }

      return $this->render('index', [
          'dataProvider' => $dataProvider,
          'searchModel' => $searchModel,
      ]);
   }

   /**
    * Displays a single AClass model.
    * @param integer $id
    * @return mixed
    */
   public function actionView($id)
   {
      return $this->render('view', [
          'model' => $this->findModel($id),
      ]);
   }

   /**
    * Creates a new AClass model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
   public function actionCreate()
   {
      $model = new AClass;

      if ($model->load(Yii::$app->request->post()) && $model->save())
      {
         return $this->redirect(['view', 'id' => $model->id]);
      } else
      {
         return $this->render('create', [
             'model' => $model,
         ]);
      }
   }

   /**
    * Updates an existing AClass model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    */
   public function actionUpdate($id)
   {
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save())
      {
         return $this->redirect(['view', 'id' => $model->id]);
      } else
      {
         return $this->render('update', [
             'model' => $model,
         ]);
      }
   }

   /**
    * Deletes an existing AClass model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    */
   public function actionDelete($id)
   {
      $this->findModel($id)->delete();

      return $this->redirect(['index']);
   }
   
   public function populateClassDivisions()
   {
      
   }

   /**
    * Finds the AClass model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return AClass the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id)
   {
      if (($model = AClass::findOne($id)) !== null)
      {
         return $model;
      } else
      {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

}
