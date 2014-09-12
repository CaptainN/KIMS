<?php

namespace app\models;

use DateTime;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "class".
 *
 * @property integer $id
 * @property integer $day_id
 * @property integer $division_id
 * @property integer $room_id
 * @property integer $instructor_id
 * @property string $start_time
 * @property integer $type_id
 * @property integer $frequency_id
 * @property integer $active
 *
 * @property Day $day
 * @property Division $division
 * @property Division $divisions
 * @property Room $room
 * @property ClassType $type
 * @property Student $instructor
 * @property Student[] $students
 */
class AClass extends \app\components\MetaModel
{

   /**
    * @inheritdoc
    */
   public static function tableName()
   {
      return 'class';
   }

   /**
    * @inheritdoc
    */
   public function rules()
   {
      return [
         [['day_id', 'division_id', 'room_id', 'instructor_id', 'type_id', 'frequency_id', 'active'], 'integer'],
         [['start_time'], 'safe']
      ];
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels()
   {
      return [
         'id' => 'ID',
         'day_id' => 'Day ID',
         'day.name' => 'Day',
         'division_id' => 'Division ID',
         'division.name' => 'Division',
         'room_id' => 'Room ID',
         'room.name' => 'Room',
         'school.name' => 'School',
         'instructor_id' => 'Instructor ID',
         'instructor.name' => 'Instructor',
         'start_time' => 'Start Time',
         'type_id' => 'Type ID',
         'type.name' => 'Type',
         'frequency_id' => 'Frequency ID',
         'frequency.name' => 'Frequency',
         'active' => 'Active',
      ];
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getDay()
   {
      return $this->hasOne(Day::className(), ['id' => 'day_id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getDivisions()
   {
      return $this->hasMany(Division::className(), ['id' => 'division_id'])
        ->viaTable('class_division', ['class_id' => 'id'])
      ;
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getRoom()
   {
      return $this->hasOne(Room::className(), ['id' => 'room_id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getSchool()
   {
      return $this->hasOne(School::className(), ['id' => 'location_id'])
        ->via('room');
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getType()
   {
      return $this->hasOne(ClassType::className(), ['id' => 'type_id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getInstructor()
   {
      return $this->hasOne(Student::className(), ['id' => 'instructor_id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getStudents()
   {
      return $this->hasMany(Student::className(), ['weapon_anchor_id' => 'id']);
   }

   /**
    * @return string
    */
   public function getFullName()
   {
      $parts1 = [];
      $parts2 = [];

      $freq = $this->frequency;
      if ($freq && $freq->ord !== 0) // don't display "every"
      {
         $parts1 [] = $freq->name;
      }

      $day = $this->day;
      if ($day && $day->id !== 0) // don't display unspecified days
      {
         $parts1 [] = $day->name;
      }

      $time = $this->start_time ? new DateTime($this->start_time) : null;
      if ($time)
      {
         $parts1 [] = $time->format('g:i A');
      }

      if (count($parts1) === 0)
      {
         $parts1 [] = 'Unknown Class';
      }

      $divisions = $this->divisions;
      $arr = [];
      foreach ($divisions as $key => $value)
      {
         $arr[] = $value->name;
      }
      $parts2[] = 'Div. ' . join(', ', $arr);

      $room = $this->room;
      if ($room)
      {
         $parts2[] = $room->name;
      }

      if (0 === $this->instructor_id)
      {
         $parts2[] = 'Maurey Levitz';
      }
      else
      {
         $instructor = $this->instructor;
         if ($instructor)
         {
            $parts2[] = $instructor->fname . ' ' . $instructor->lname;
         }
      }

      return join(' ', $parts1) . ' / ' . join(' / ', $parts2);
   }

   /**
    * @return string
    */
   public function getName()
   {
      $day = $this->day;
      $dayName = isset($day) ? $day->abbr : null;
      $time = isset($this->start_time) ? strtotime($this->start_time) : null;
      $freq = $this->frequency;
      $ord = isset($freq) ? $freq->ord : -1;

      if (isset($day) && isset($freq) && 0 === $ord) // every week
      {
         $name = $dayName . (isset($time) ? date(' gi', $time) : '');
      } elseif (isset($day) && isset($freq) && $ord > 0)
      {
         // if the frequency value is > 5 (fifth instance of a day per month)
         // then just show the frequency name
         $name = ($ord > 5 ? (isset($freq->abbr) ? $freq->abbr : $freq->name) :
           $ord . $dayName . (isset($time) ? date(' gi', $time) : ''));
      } elseif (isset($freq))
      {
         // just show the frequency abbr/name
         $name = isset($freq->abbr) ? $freq->abbr : $freq->name;
      } else
      {
         $name = '?';
      }

      return trim($name);
   }

   /**
    * * @return \yii\db\ActiveQuery relation
    */
   public function getFrequency()
   {
      return $this->hasOne(ClassFrequency::className(), ['id' => 'frequency_id']);
   }

}
