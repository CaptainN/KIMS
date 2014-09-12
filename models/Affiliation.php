<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "affiliation".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $student_id
 * @property integer $school_id
 * @property integer $role_id
 * @property integer $hand_anchor_id
 * @property integer $weapon_anchor_id
 * @property string $date
 *
 * @property Class $weaponAnchor
 * @property Student $student
 * @property Class $handAnchor
 */
class Affiliation extends \app\components\MetaModel
{

   /**
    * @inheritdoc
    */
   public static function tableName()
   {
      return 'affiliation';
   }

   /**
    * @inheritdoc
    */
   public function rules()
   {
      return [
         [['active', 'student_id', 'school_id', 'role_id', 'hand_anchor_id', 'weapon_anchor_id'], 'integer'],
         [['student_id', 'school_id', 'role_id', 'hand_anchor_id'], 'required'],
         [['student_id', 'school_id'], 'unique', 'targetAttribute' => ['student_id', 'school_id'], 'message' => 'Already affiliated with this school.'],
      ];
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels()
   {
      return [
         'id' => 'ID',
         'active' => 'Active',
         'student_id' => 'Student',
         'school_id' => 'School',
         'school.name' => 'School',
         'role_id' => 'Role',
         'role.name' => 'Role',
         'hand_anchor_id' => 'Hand Anchor',
         'handAnchor.name' => 'Hand Anchor',
         'weapon_anchor_id' => 'Weapon Anchor',
         'weaponAnchor.name' => 'Weapon Anchor',
      ];
   }

   public function getIsContract()
   {
      return $this->school_id === $this->student->contract_school_id;
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getStudent()
   {
      return $this->hasOne(Student::className(), ['id' => 'student_id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getSchool()
   {
      return $this->hasOne(School::className(), ['id' => 'school_id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getRole()
   {
      return $this->hasOne(Role::className(), ['id' => 'role_id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getWeaponAnchor()
   {
      return $this->hasOne(AClass::className(), ['id' => 'weapon_anchor_id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getHandAnchor()
   {
      return $this->hasOne(AClass::className(), ['id' => 'hand_anchor_id']);
   }

}
