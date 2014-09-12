<?php
namespace app\components;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * 
 */
class KimsController extends \yii\web\Controller
{
   
   public function behaviors()
   {
      return [
         'access' => [
            'class' => AccessControl::className(),
            'rules' => [
               // All logged in users ('@') have access
               // Guests ('?') do not have access
               ['allow' => true, 'roles' => ['@']],
               ['allow' => false, 'roles' => ['?']],
            ],
         ],
         'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
               'delete' => ['post'],
               'editable' => ['post'],
               'toggle' => ['post'],
               'select' => ['get'],
            ],
         ],
      ];
   }

   public function renderJson($data)
   {
      header('Content-Type: application/json');
      return Json::encode($data);
   }
   
}
?>