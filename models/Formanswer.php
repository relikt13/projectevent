<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "formanswer".
 *
 * @property int $id
 * @property int $line_id
 * @property string $value
 * @property int $userform_id
 *
 * @property Formline $line
 * @property Userform $userform
 */
class Formanswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'formanswer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['line_id', 'userform_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['line_id'], 'exist', 'skipOnError' => true, 'targetClass' => Formline::className(), 'targetAttribute' => ['line_id' => 'id']],
            [['userform_id'], 'exist', 'skipOnError' => true, 'targetClass' => Userform::className(), 'targetAttribute' => ['userform_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'line_id' => 'Line ID',
            'value' => 'Value',
            'userform_id' => 'Userform ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLine()
    {
        return $this->hasOne(Formline::className(), ['id' => 'line_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserform()
    {
        return $this->hasOne(Userform::className(), ['id' => 'userform_id']);
    }
}
