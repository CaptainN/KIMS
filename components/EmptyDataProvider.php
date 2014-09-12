<?php

namespace app\components;

class EmptyDataProvider extends \yii\data\ActiveDataProvider
{   
   public function getModels()
   {
      $models = [];
      for ($i = 0; $i < $this->newRowCount; ++$i)
      {
         $models[] = new $this->modelClass();
      }
      return $models;
   }
   
   protected function prepareModels()
   {
      
   }
   
   protected function prepareKeys($models)
   {
   
   }
   
   protected function prepareTotalCount()
   {
   
   }
   
   public $modelClass = null;
   
   public $newRowCount = 10;
}
?>