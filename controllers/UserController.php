<?php

namespace app\controllers;

use Yii;
use dosamigos\editable\EditableAction;
use app\models\User;
use yii\web\NotFoundHttpException;

class UserController extends \app\components\KimsController
{
   public function actions()
   {
      return array_merge(parent::actions(), [
         'editable' => [
            'class' => EditableAction::className(),
            'modelClass' => User::className(),
            'forceCreate' => false,
         ],
      ]);
   }
   
   public function actionConfig()
   {
      $model = Yii::$app->user->identity;

      if ($model->load(Yii::$app->request->post()) && $model->save())
      {
         return $this->redirect(['/']);
      }
      else
      {
         return $this->render('config', [
            'model' => Yii::$app->user->identity,
         ]);
      }
   }
   
   /**
    * Finds a User model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return Room the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id)
   {
      if (($model = User::findOne($id)) !== null)
      {
         return $model;
      }
      else
      {
         throw new NotFoundHttpException('The requested user does not exist.');
      }
   }
}

?>