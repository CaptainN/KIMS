<?php

namespace app\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "meta".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $parent_class
 * @property integer $parent_id
 * @property string $child_class
 * @property integer $child_id
 *
 * @property Student $parent
 */
class Meta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'safe'], // will be serialized
            [['json_value'], 'string', 'max' => 254],
            [['parent_id', 'child_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['parent_class', 'child_class'], 'string', 'max' => 128],
            [['parent_class', 'parent_id', 'name'], 'unique', 'targetAttribute' => ['parent_class', 'parent_id', 'name'], 'message' => 'The combination of Name, Parent Class and Parent ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'json_value' => 'JSON',
            'parent_class' => 'Parent Class',
            'parent_id' => 'Parent ID',
            'child_class' => 'Child Class',
            'child_id' => 'Child ID',
        ];
    }
    
   /**
    * @inheritdoc
    */
   /*public function afterFind()
   {
      $value = Json::decode($this->getAttribute('value'));
      $this->setAttribute('value', $value);
      $this->setOldAttribute('value', $value);
      $valueIsSerialized = false;
      parent::afterFind();
   }*/
    
   /**
    * @inheritdoc
    */
   /*public function beforeSave($insert)
   {
      if (parent::beforeSave($insert))
      {
         if (!$valueIsSerialized)
         {
            $value = Json::encode($this->getAttribute('value'));
            $this->setAttribute('value', $value);
            $oldValue = Json::encode($this->getOldAttribute('value'));
            $this->setOldAttribute('value', $oldValue);
            $valueIsSerialized = true;
         }
         return true;
      } else {
         return false;
      }
   }*/
   
   /**
    * Decode the JSON stored in the database.
    */
   public function getValue()
   {
      return Json::decode($this->json_value);
   }
   
   /**
    * Decode the JSON stored in the database.
    */
   public function setValue($newValue)
   {
      $this->json_value = Json::encode($newValue);
   }
}
