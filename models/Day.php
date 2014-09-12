<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "day".
 *
 * @property integer $id
 * @property integer $ord
 * @property string $name
 * @property string $abbr
 *
 * @property Class[] $classes
 */
class Day extends \app\components\MetaModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'day';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 45],
            [['abbr'], 'string', 'max' => 4],
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
            'abbr' => 'Abbr',
        ];
    }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getClasses()
   {
       return $this->hasMany(AClass::className(), ['day_id' => 'id']);
   }
}
