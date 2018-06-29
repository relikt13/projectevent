<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $image
 * @property string $content
 * @property int $page_id
 *
 * @property Page $page
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'],'required'],
            [['page_id'], 'integer'],
            [['image', 'content'], 'string', 'max' => 255],
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
            'image' => 'Image',
            'content' => 'Content',
            'page_id' => 'Page ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    public function saveImage($file){
        $this->image = $file;
        return $this->save(false);
    }

    public function deleteImage(){
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteFileImage($this->image);
    }

    public function beforeDelete()
    {

        $this->deleteImage();
        return parent::beforeDelete();
    }
}
