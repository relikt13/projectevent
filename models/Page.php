<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $image
 * @property int $category_id
 * @property int $active
 * @property int $views
 * @property string $date
 *
 * @property Formtable[] $formtables
 * @property Image[] $images
 * @property Opinion[] $opinions
 * @property Category $category
 */
class Page extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content','title','date'],'required'],
            [['content'], 'string'],
            [['category_id','user_id'], 'integer'],
            [['date'], 'date','format'=>'php: Y-m-d'],
            [['title','slug'], 'string', 'max' => 255],
            [['description'],'string', 'max'=>100],
            [['active'], 'string', 'max' => 1],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Краткое описание',
            'content' => 'Контент',
            'image' => 'Афиша',
            'category_id' => 'Категория',
            'active' => 'Active',
            'user_id' => 'Автор',
            'date' => 'Дата проведеня (Y-m-d)',
            'slug' => 'Slug'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormtables()
    {
        return $this->hasMany(Formtable::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinion::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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

        $models = Formtable::find()->where(['page_id'=>$this->id])->all();
        foreach ($models as $model){
            $model->delete();
        }


        $models = Lay::find()->where(['page_id'=>$this->id])->all();
        foreach ($models as $model){
            $model->delete();
        }


        $models = Opinion::find()->where(['page_id'=>$this->id])->all();
        foreach ($models as $model){
            $model->delete();
        }


        $models = Image::find()->where(['page_id'=>$this->id])->all();
        foreach ($models as $model){
            $model->delete();
        }

        $this->deleteImage();
        return parent::beforeDelete();
    }
}
