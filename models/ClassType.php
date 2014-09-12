<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "class_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $active
 *
 * @property Class[] $classes
 */
class ClassType extends \app\components\MetaModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'class_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 45]
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
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasses()
    {
        return $this->hasMany(AClass::className(), ['type_id' => 'id']);
    }
}
