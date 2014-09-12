<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "location_address".
 *
 * @property integer $id
 * @property integer $location_id
 * @property integer $address_id
 * @property integer $address_type_id
 * @property integer $order
 * @property integer $active
 *
 * @property Address $address
 * @property Location $location
 */
class LocationAddress extends \app\components\MetaModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_id', 'address_id', 'address_type_id', 'order'], 'required'],
            [['location_id', 'address_id', 'address_type_id', 'order', 'active'], 'integer']
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
            'address_id' => 'Address ID',
            'address_type_id' => 'Address Type ID',
            'order' => 'Order',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }
}
