<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.04.2018
 * Time: 14:32
 */

namespace app\models;


use Yii;
use yii\base\Model;

class ImageUpload extends Model
{
    public $image;

    public function rules()
    {
       return [
         [['image'],'required'],
         [['image'],'file','extensions'=>'jpg,png']
       ];
    }

    public function uploadImage($file,$currentimage){
        $this->image = $file;
        if($this->validate()) {
            $this->deleteFileImage($currentimage);
            return $this->saveImage();
        }
        return false;
    }

    public function getFolder(){
        return Yii::getAlias('@web') ;
    }

    public function generateFilename(){
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    public function deleteFileImage($currentimage){
        if ($this->fileExist($currentimage)) {
            unlink($this->getFolder().$currentimage);
            return true;
        }
        return false;
    }

    public function fileExist($currentimage){
        return $currentimage && file_exists($this->getFolder().$currentimage);
    }

    public function saveImage(){
        $filename = $this->generateFilename();
        $this->image->saveAs($this->getFolder(). $filename);
        return $filename;
    }
}