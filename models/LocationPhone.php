<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "location_phone".
 *
 * @property integer $id
 * @property integer $location_id
 * @property integer $phone_id
 * @property integer $order
 * @property integer $active
 */
class LocationPhone extends \app\components\MetaModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location_phone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_id', 'phone_id', 'order'], 'required'],
            [['location_id', 'phone_id', 'order', 'active'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location_id' => 'Location ID',
            'phone_id' => 'Phone ID',
            'order' => 'Order',
            'active' => 'Active',
        ];
    }
}
