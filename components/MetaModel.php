<?php
namespace app\components;

use app\models\Meta;
use yii\helpers\ArrayHelper;

/**
 * Allows storing metadata about models in the meta table, as JSON
 */
class MetaModel extends \yii\db\ActiveRecord
{
   /**
    * @return mixed
    */
   public function __get($name)
   {
      // if the attribute is defined as a meta-attribute, fetch it
      // otherwise let the parent class handle the request
      if ($this->hasMetaAttribute($name))
      {
         return $this->getMeta($name);
      }
      else if (($val = ArrayHelper::getValue ($this, $name)) !== null)
      {
         return $val;
      }
      else
      {
         return parent::__get($name);
      }
   }
   
   /**
    * @inheritdoc
    */
   public function __set($name, $newValue)
   {
      if($this->hasMetaAttribute($name))
      {
         $this->setMeta($name, $newValue);
      }
      else
      {
         parent::__set($name, $newValue);
      }
   }
   
   /**
    * Checks if the model has any dirty attributes, and needs to be saved.
    * @return boolean
    */
   public function getIsDirty()
   {
      return count($this->dirtyAttributes) > 0;
   }
   
   /**
    * Checks if the model has been saved (has no dirty attributes).
    * @return boolean
    */
   public function getIsSaved()
   {
      return count($this->dirtyAttributes) === 0;
   }
   
   /**
    * When defined by a subclass, use:
    * return array_merge(parent::metaAttributes(), ['new1', 'new2']);
    * @return array of meta attribute names ['meta', 'meta2']
    */
   public function metaAttributes()
   {
      return [];
   }
   
   /**
    * Determines whether a given attribute is available through the meta table.
    * @param string $name of the attribute
    * @return boolean
    */
   public function hasMetaAttribute($name)
   {
      return in_array($name, $this->metaAttributes()) ||
       array_key_exists($name, $this->metaAttributes());
   }
   
   /**
    * @return mixed the value of the given name or the default, if none
    */
   private function getMeta($name, $defaultValue = null, $returnModel = false)
   {
      $data = [
       'name' => $name,
       'parent_class' => self::className(),
       'parent_id' => $this->id,
      ];
      $meta = Meta::findOne($data);
      if ($returnModel)
      {
         if (!isset($meta))
         {
            $meta = new Meta();
            $data['value'] = $defaultValue;
            $meta->load(['data' => $data], 'data');
         }
         return $meta;
      }
      else
      {
         return isset($meta) ? $meta->value : $defaultValue;
      }
   }
   
   /**
    * Saves a meta value.
    */
   private function setMeta($name, $newValue)
   {
      $meta = $this->getMeta($name, '', true);
      $meta->value = $newValue;
      $meta->save();
   }
}
?>