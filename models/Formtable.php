<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "formtable".
 *
 * @property int $id
 * @property int $page_id
 * @property int $to_guest
 * @property string $title
 *
 * @property Formline[] $formlines
 * @property Page $page
 * @property Userform[] $userforms
 */
class Formtable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'formtable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id'], 'integer'],
            [['to_guest'], 'integer', 'max' => 1],
            [['title'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'to_guest' => 'To Guest',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormlines()
    {
        return $this->hasMany(Formline::className(), ['form_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserforms()
    {
        return $this->hasMany(Userform::className(), ['form_id' => 'id']);
    }

    public function beforeDelete()
    {
        $models = Formline::find()->where(['form_id'=>$this->id])->all();
        foreach ($models as $model){
            $model->delete();
        }


        $models = Userform::find()->where(['form_id'=>$this->id])->all();
        foreach ($models as $model){
            $model->delete();
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }
}