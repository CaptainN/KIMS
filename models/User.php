<?php

namespace app\models;

use Yii;

class User extends \auth\models\User
{

   /**
    * @inheritdoc
    */
   public function init()
   {
      parent::init();
   }

   /**
    * @inheritdoc
    */
   public function rules()
   {
      return array_merge(parent::rules(), [
         ['schoolId', 'integer'],
         ['rowsPerPage', 'integer'],
         ['reportMonth', 'safe'],
      ]);
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels()
   {
      return array_merge(parent::attributeLabels(), [
         'schoolId' => 'School ID',
      ]);
   }

   /**
    * @inheritdoc
    */
   public function attributes()
   {
      return array_merge(parent::attributes(), [
      ]);
   }

   /**
    * @inheritdoc
    */
   public function beforeSave($insert)
	{
      //dump($this->dirtyAttributes);
		return parent::beforeSave($insert);
	}

   /**
    * @inheritdoc
    */
   public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);
	}

   /**
    * @return mixed the value of the given option or the default, if none
    */
   public function getOption($name, $defaultValue = null, $returnModel = false)
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
    * Saves a user option.
    */
   public function setOption($name, $newValue)
   {
      $meta = $this->getOption($name, '', true);
      $meta->value = $newValue;
      $meta->save();
   }

   public function getRowsPerPage($default = 20)
   {
      return $this->getOption('rowsPerPage', $default);
   }

   public function setRowsPerPage($newValue)
   {
      return $this->setOption('rowsPerPage', (int)$newValue);
   }

   public function getSchoolId()
   {
      return $this->getOption('schoolId', 0);
   }

   public function setSchoolId($newValue)
   {
      return $this->setOption('schoolId', (int)$newValue);
   }

   /**
    * Each user can only be affiliated with one school at a time;
    * Admins can change their school at any time.
    * @return \yii\db\ActiveQuery
    */
   public function getSchool()
   {
      return School::findOne($this->schoolId);
   }

   public function getReportMonth()
   {
      return $this->getOption('reportMonth', null);
   }

   public function setReportMonth($newValue)
   {
      if (gettype($newValue) === 'string')
      {
         $newValue = strtotime($newValue);
      }
      $dateString = date('M Y', $newValue);
      $this->setOption('reportMonth', $dateString);
   }
}
