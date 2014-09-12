<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "division".
 *
 * @property integer $id
 * @property integer $active
 * @property string $name
 * @property integer $order
 *
 * @property Class[] $classes
 */
class Division extends \app\components\MetaModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'division';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'order'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['order'], 'unique'],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'active' => 'Active?',
            'name' => 'Name',
            'order' => 'Order',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function togglableAttributes()
    {
        return [
            'active',
        ];
    }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getClasses()
   {
       return $this->hasMany(AClass::className(), ['division_id' => 'id']);
   }
   
   /**
    * @return \yii\db\ActiveQuery
    */
   public function getClassDivisions()
   {
       return $this->hasMany(ClassDivision::className(), ['division_id' => 'id']);
   }
   
   public static function getMap()
   {
      return ArrayHelper::map(
         Division::find()
          ->where(['active' => 1])
          ->orderBy('ord')
          ->asArray()->all(),
         'id', 'name'
       );
   }
}
