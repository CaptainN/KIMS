<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "class_frequency".
 *
 * @property integer $id
 * @property string $name
 * @property integer $value
 */
class ClassFrequency extends \app\components\MetaModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'class_frequency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['ord'], 'integer'],
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
            'ord' => 'Ord',
        ];
    }
}
