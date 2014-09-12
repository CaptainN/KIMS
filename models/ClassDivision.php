<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "class_division".
 *
 * @property integer $id
 * @property integer $class_id
 * @property integer $division_id
 *
 * @property Division $division
 * @property Class $class
 */
class ClassDivision extends \app\components\MetaModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'class_division';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_id', 'division_id'], 'integer'],
            [['class_id', 'division_id'], 'unique', 'targetAttribute' => ['class_id', 'division_id'], 'message' => 'The combination of Class ID and Division ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_id' => 'Class ID',
            'division_id' => 'Division ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivision()
    {
        return $this->hasOne(Division::className(), ['id' => 'division_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(AClass::className(), ['id' => 'class_id']);
    }
}
