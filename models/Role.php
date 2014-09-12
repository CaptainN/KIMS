<?php

namespace app\models;

use Yii;
use \yii\helpers\ArrayHelper;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $name
 * @property integer $ord
 *
 * @property Affiliations[] $affiliations
 */
class Role extends \app\components\MetaModel
{

   /**
    * @inheritdoc
    */
   public static function tableName()
   {
      return 'role';
   }

   /**
    * @inheritdoc
    */
   public function rules()
   {
      return [
         [['name'], 'string', 'max' => 45],
         [['ord'], 'integer'],
      ];
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels()
   {
      return [
         'id' => 'ID',
         'ord' => 'Ord',
         'name' => 'Name',
      ];
   }

   /**
    * @return \yii\db\ActiveQuery relation
    */
   public function getAffiliations()
   {
      return $this->hasMany(Affiliation::className(), ['role_id' => 'id']);
   }

   public static function getMap()
   {
      return ArrayHelper::map(Role::find()
         ->where(['active' => 1])->orderBy('ord')->all(), 'id', 'name');
   }

}
