<?php

namespace app\models;

use \DateTime;
use \Yii;
use \yii\helpers\Json;
use \yii\helpers\ArrayHelper;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property string $fname
 * @property string $mname
 * @property string $lname
 * @property integer $division_id
 * @property string $kai_number
 * @property string $belt_size
 * @property string $gi_size
 * @property string $dob
 * @property string $email
 * @property string $notes
 * @property string $spar_auth
 * @property string $grapple_auth
 * @property string $prefix
 * @property string $gender
 * @property integer $active
 * @property string $start_date
 * @property integer $contract_school_id
 *
 * @property AClass[] $classes
 * @property AClass $handAnchor
 * @property AClass[] $handAnchors
 * @property AClass $weaponAnchor
 * @property AClass[] $weaponAnchors
 * @property Location $contractSchool
 * @property StudentPhone $bestPhone
 * @property StudentPhone[] $phones
 * @property StudentAddress $bestAddress
 * @property StudentAddress[] $addresses
 */
class Student extends \app\components\MetaModel
{

   /**
    * @inheritdoc
    */
   public static function tableName()
   {
      return 'student';
   }

   /**
    * @inheritdoc
    */
   public function rules()
   {
      return [
         // convert bitwise checklists to a single int
         //[['spar_auth', 'grapple_auth'], 'default', 'value' => []],
         //[['spar_auth', 'grapple_auth'], 'filter', 'filter' => function($value){return isset($value) ? array_sum($value) : 0;}],
         //[['spar_auth', 'grapple_auth'], 'filter', 'filter' => function($value){return array_sum($value);}],
         // no longer doing this bitwise

         [['fname', 'lname'], 'required'],
         [['fname', 'lname'], 'string', 'max' => 45],
         [['mname'], 'string', 'max' => 90],
         [['gender'], 'required'],
         [['gender'], 'string', 'max' => 1],
         [['dob'], 'required'],
         [['dob'], 'string', 'min' => 10],
         [['dob'], 'string', 'max' => 10],
         [['belt_size'], 'required'],
         [['belt_size'], 'string', 'max' => 1],
         [['division_id'], 'required'],
         [['division_id', 'active'], 'integer'],
         [['spar_auth', 'grapple_auth'], 'string'],
         [['sparAuth', 'grappleAuth'], 'safe'],
         [['notes'], 'string'],
         [['kai_number'], 'string', 'max' => 6],
         [['email'], 'string', 'max' => 254],
         [['fname', 'lname', 'mname'], 'unique', 'targetAttribute' => ['fname', 'lname', 'mname'], 'message' => 'Full name is already taken.'],
      ];
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels()
   {
      return [
         'id' => 'ID',
         'fname' => 'First Name',
         'mname' => 'Middle Name(s)',
         'lname' => 'Last Name',
         'division_id' => 'Division',
         'rank.name' => 'Rank',
         'role.name' => 'Role',
         'kai_number' => 'Kai Number',
         'belt_size' => 'Obi sz',
         'gi_size' => 'Gi sz',
         'dob' => 'DoB',
         'dobMdy' => 'Date of Birth',
         'dobAndAge' => 'DoB (Age)',
         'handAnchor.name' => 'Anchor',
         'weaponAnchor.name' => 'Weapon Anchor',
         'email' => 'Email',
         'notes' => 'Notes',
         'spar_auth' => 'Spar',
         'sparAuth' => 'Spar',
         'grappleAuth' => 'Grap',
         'gender' => 'Gender',
         'prefix' => 'Mr/Ms',
         'active' => 'Active',
         'bestPhoneNumber' => 'Best Phone',
      ];
   }

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
   public function metaAttributes()
   {
      return array_merge(parent::metaAttributes(), [
      ]);
   }

   /**
    * @return \app\models\StudentPhone
    */
   public function getBestPhone()
   {
      return StudentPhone::find()
        ->joinWith('student')
        ->where(['student.id' => $this->id])
        ->orderBy(['student_phone.ord' => SORT_ASC])
        ->one();
   }

   public function getBestPhoneNumber()
   {
      return $this->bestPhone->number;
   }

   public function setBestPhoneNumber($newValue)
   {
      $phone = $this->bestPhone;
      $phone->number = $newValue;
      $phone->save(true, ['number']);
   }

   /**
    * @return \yii\db\ActiveQuery relation
    */
   public function getPhones()
   {
      return $this->hasMany(StudentPhone::className(), ['student_id' => 'id']);
   }

   /**
    * @return \yii\db\ActiveQuery relation
    */
   public function getAddresses()
   {
      return $this->hasMany(StudentAddress::className(), ['student_id' => 'id']);
   }

   /**
    * @return \app\Models\StudentAddress
    */
   public function getBestAddress()
   {
      return StudentAddress::find()
        ->joinWith('student')
        ->where(['student.id' => $this->id])
        ->orderBy(['student_address.ord' => SORT_ASC])
        ->one();
   }

   /**
    * @return \yii\db\ActiveQuery relation
    */
   public function getDivision()
   {
      return $this->hasOne(Division::className(), ['id' => 'division_id']);
   }

   /**
    * @return \yii\db\ActiveQuery relation
    */
   public function getAffiliation()
   {
      return $this->hasOne(Affiliation::className(), ['student_id' => 'id'])
        ->onCondition(['school_id' => Yii::$app->user->schoolId]);
   }

   /**
    * @return \yii\db\ActiveQuery relation
    */
   public function getAffiliations()
   {
      return $this->hasMany(Affiliation::className(), ['student_id' => 'id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getRole()
   {
      return $this->hasOne(Role::className(), ['id' => 'role_id'])
        ->via('affiliation');
   }

   /**
    * @return \yii\db\ActiveQuery relation
    */
   public function getClasses()
   {
      return $this->hasMany(AClass::className(), ['instructor_id' => 'id']);
   }

   /**
    * @return \yii\db\ActiveQuery relation
    */
   public function getPromotions()
   {
      return $this->hasMany(Promotion::className(), ['student_id' => 'id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getRank()
   {
      $lastPromotion = Promotion::find()
       ->where(['student_id' => $this->id, 'active' => 1])
       ->orderBy(['promotion.date' => SORT_DESC])
       ->one();
      return Rank::findOne($lastPromotion->rank_id);
   }

   /**
    * @return \yii\db\ActiveRecord
    */
   public function getHandAnchor()
   {
      return $this->affiliation->handAnchor;
   }

   /**
    * @return \app\models\AClass[] available class choices
    */
   public function getHandAnchors()
   {
      return AClass::find()
        ->joinWith(['school', 'day', 'frequency', 'type', 'divisions'])
        ->where([
           'class_type.name' => 'Hand Kata',
           'location_id' => Yii::$app->user->schoolId,
        ])
        ->andFilterWhere(['class_division.division_id' => $this->division_id])
        // include the current anchor, in case it's in a different division
        ->orFilterWhere(['class.id' => $this->affiliation->hand_anchor_id])
        ->orderBy(['day.ord' => SORT_ASC, 'start_time' => SORT_ASC])
        ->all()
      ;
   }

   /**
    * @return integer
    */
   public function getHandAnchorId()
   {
      return $this->handAnchor->id;
   }

   /**
    * Called by Editable
    */
   public function setHandAnchorId($value)
   {
      $this->affiliation->hand_anchor_id = (int) $value;
      $this->affiliation->save(true, ['hand_anchor_id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getWeaponAnchor()
   {
      return $this->affiliation->weaponAnchor;
   }

   /**
    * @return integer
    */
   public function getWeaponAnchorId()
   {
      return $this->weaponAnchor->id;
   }

   /**
    * Called by Editable
    */
   public function setWeaponAnchorId($value)
   {
      $this->affiliation->weapon_anchor_id = (int) $value;
      $this->affiliation->save(true, ['weapon_anchor_id']);
   }

   /**
    * @return \app\models\AClass[] available class choices
    */
   public function getWeaponAnchors()
   {
      return AClass::find()
        ->joinWith(['school', 'day', 'frequency', 'type'])
        ->andWhere(['location_id' => Yii::$app->user->schoolId])
        ->andWhere(['class_type.name' => 'Weapons'])
        //->andWhere(['class_frequency.ord' => 0]) // every week
        // :???: class has no division_id
        //->andFilterWhere(['division_id' => $this->division_id])
        // include the current anchor, in case it's in a different division
        ->orFilterWhere(['class.id' => $this->affiliation->weapon_anchor_id])
        ->orderBy(['-`day`.`ord`' => SORT_DESC, 'start_time' => SORT_ASC])
        ->all()
      ;
   }

   /**
    * @return \yii\db\ActiveQuery relation
    */
   public function getContractSchool()
   {
      return $this->hasOne(School::className(), ['id' => 'contract_school_id']);
   }

   /**
    * The DoB in American format
    * @return string
    */
   public function getDobMdy()
   {
      $dt = new DateTime($this->dob);
      return $dt->format('m/d/Y');
   }

   /**
    * Set the DoB usingn American m/d/y format
    * @return string
    */
   public function setDobMdy($value)
   {
      if (preg_match('~\d+/\d+/\d+~', $value))
      {
         $dt = new DateTime($value);
         $this->_dob = $dt->format('Y-m-d');
      }
   }

   /**
    * @return float age in years
    */
   public function getAge()
   {
      $dob = new DateTime($this->dob);
      return $dob->diff(new DateTime())->days / 365;
   }

   /**
    * @return string like m/d (age)
    */
   public function getDobAndAge()
   {
      if (0 === strlen($this->dob))
         return null;
      $dob = new DateTime($this->dob);
      $age = round($this->age, 1);
      return $dob->format('n/j') . ($age > 21 ? '' : ", {$age}");
   }

   /**
    * The student's name ni last, first format
    * @return string
    */
   public function getName()
   {
      $name = '';

      $last = $this->lname;
      $name .= strlen($last) ? $last : '';

      $first = $this->fname;
      $name .= strlen($first) ? ', ' . $first : '';

      $mid = $this->mname;
      $name .= strlen($mid) ? ' ' . $mid : '';

      return $name;
   }

   public function getFullName()
   {
      return $this->name;
   }

   public function getSparAuthJson()
   {
      return $this->spar_auth;
   }

   public function getSparAuth()
   {
      return Json::decode($this->spar_auth);
   }

   /**
    * @param $newValue array of values from sparAuthMap, e.g. ["b", "c"]
    */
   public function setSparAuth($newValue)
   {
      $this->spar_auth = Json::encode($newValue);
   }

   public function getGrappleAuthJson()
   {
      return $this->grapple_auth;
   }

   public function getGrappleAuth()
   {
      return Json::decode($this->grapple_auth);
   }

   /**
    * @param $newValue array of values from grappleAuthMap, e.g. ["rws", "a"]
    */
   public function setGrappleAuth($newValue)
   {
      $this->grapple_auth = Json::encode($newValue);
   }

   public function beforeSave($insert)
   {
      if (parent::beforeSave($insert))
      {
         // if nothing was checked in the checkbox lists, resulting in
         // them ebing set to double quotes, turn them into JSON manually
         if ('""' === ($v = $this->grapple_auth))
         {
            $this->grapple_auth = '[' . $v . ']';
         }
         if ('""' === ($v = $this->spar_auth))
         {
            $this->spar_auth = '[' . $v . ']';
         }
         return true;
      } else
      {
         return false;
      }
   }

   /*public function afterSave($insert, $changedAttributes)
   {
      // placeholder (nothing extra to do at this point)
      parent::afterSave($insert, $changedAttributes);
   }*/

   public static function getDivisionMap()
   {
      return [
         '1' => '1',
         '2' => '2',
         '3' => '3',
         '4' => '4',
      ];
   }

   public static function getGiSizeMap()
   {
      return [
         '1' => '1',
         '2' => '2',
         '3' => '3',
         '4' => '4',
         '5' => '5',
         '6' => '6',
         '7' => '7',
         '8' => '8',
         '9' => '9',
      ];
   }

   public static function getSparAuthList($map = false)
   {
      $data = [
         ['value' => 'B', 'text' => 'Block'],
         ['value' => 'C', 'text' => 'Counter'],
         ['value' => 'I', 'text' => 'Initiate'],
         ['value' => 'A', 'text' => 'Authorized'],
      ];
      if ($map)
      {
         return ArrayHelper::map($data, 'value', 'text');
      }
      return $data;
   }

   public static function getGrappleAuthList($map = false)
   {
      $data = [
         ['value' => 'RWS', 'text' => 'Roll With Staff'],
         ['value' => 'A', 'text' => 'Authorized'],
      ];
      if ($map)
      {
         return ArrayHelper::map($data, 'value', 'text');
      }
      return $data;
   }

}
