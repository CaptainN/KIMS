<?php

namespace app\models;

use Yii;
use \yii\helpers\ArrayHelper;

/**
 * This is the model class for schools.
 *
 * @property integer $id
 * @property string $name
 * @property string $abbr
 * @property string $kai_template
 * @property integer $active
 *
 * @property Student[] $students
 * @inheritdoc
 */
class School extends Location
{

   /**
    * @inheritdoc
    */
   public function rules()
   {
      $rules = parent::rules();
      $rules[] = [['abbr'], 'string', 'max' => 8];
      $rules[] = [['kai_template'], 'string', 'max' => 10];
      return $rules;
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels()
   {
      $attributeLabels = parent::attributeLabels();
      $attributeLabels['abbr'] = 'Abbr';
      $attributeLabels['kai_template'] = 'Kai Template';
      return $attributeLabels;
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
    * @inherticdoc
    */
   public function metaAttributes()
   {
      return [
         'abbr' => 'string',
         'kai_template' => 'string',
      ];
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getStudents()
   {
      return $this->hasMany(Student::className(), ['school_id' => 'id']);
   }

   public static function getMap()
   {
      return ArrayHelper::map(School::findAll(['active' => 1]), 'id', 'name');
   }

}
