<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Student;
use app\models\AClass;
use app\models\ClassDivision;

/**
 * Set up auth items, rules & roles.
 *
 * @author ds 2014-06-19
 */

class MigrationController extends Controller
{  
   public function actionIndex()
   {
   }
   
   public function actionRunall()
   {
   }
   
   /**
    */
   public function actionPopulateclassdivisions()
   {
      ClassDivision::deleteAll();
      
      $classes = AClass::find()->all();
      $groups = [];
      
      foreach ($classes as $class)
      {
         $key = join('|', [
            $class->room_id,
            $class->day_id,
            $class->type_id,
            $class->frequency_id,
            $class->start_time,
         ]); 
         //echo $key . ': ' . $class->fullName . PHP_EOL;
         if (!isset($groups[$key]))
         {
            $groups[$key] = [];
         }
         $groups[$key][] = $class;
      }
      
      foreach ($groups as $key => $group)
      {
         $classId = null;
         foreach ($group as $class)
         {
            // use the ID of the first class in the group for all of them
            if (null === $classId)
            {
               $classId = $class->id;
            }
            $cd = new ClassDivision;
            $cd->class_id = $classId;
            $cd->division_id = $class->division_id;
            if (!$cd->save())
            {
               echo $key . ' failed to save' . PHP_EOL;
            }
         }
      }
   }
}