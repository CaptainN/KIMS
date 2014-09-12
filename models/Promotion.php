<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promotion".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $student_id
 * @property integer $rank_id
 * @property string $date
 * @property integer $testing_session_id
 *
 * @property Student $student
 * @property Rank $rank
 */
class Promotion extends \app\components\MetaModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promotion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'student_id', 'rank_id', 'testing_session_id'], 'integer'],
            [['student_id', 'rank_id'], 'required'],
            [['date'], 'safe'],
            [['student_id', 'rank_id'], 'unique', 'targetAttribute' => ['student_id', 'rank_id'], 'message' => 'This Rank has already been attained.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'active' => 'Active',
            'student_id' => 'Student',
            'rank_id' => 'Rank',
            'date' => 'Date',
            'testing_session_id' => 'Testing Session',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRank()
    {
        return $this->hasOne(Rank::className(), ['id' => 'rank_id']);
    }
}
