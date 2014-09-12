<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_affiliation".
 *
 * @property integer $user_id
 * @property integer $school_id
 * @property integer $level
 *
 * @property Location $school
 * @property User $user
 */
class UserAffiliation extends \app\components\MetaModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_affiliation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'school_id'], 'required'],
            [['user_id', 'school_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'school_id' => 'School ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(Location::className(), ['id' => 'school_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
