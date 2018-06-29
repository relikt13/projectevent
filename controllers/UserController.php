<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.05.2018
 * Time: 20:55
 */

namespace app\controllers;


use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class UserController extends Controller
{

    public function actionIndex(){
        if(Yii::$app->user->isGuest){
            return $this->render('/site/error',[
                'message'=>'403'
            ]);
        }
        $user  = User::findOne(['id'=>Yii::$app->user->identity->id]);
        $way = Yii::getAlias('@web').$user->image;
        if ($user->load(Yii::$app->request->post()) ) {
            $image = UploadedFile::getInstance($user,'image');
            if(isset($image)) {
                $filename = 'upload/avatars/' . Yii::$app->security->generateRandomString(10) . '.' . $image->extension;
                $image->saveAs($filename);
                if (file_exists($way)) {
                    unlink($way);
                }
                $user->image = $filename;
            } else {
                $user->image = $way;
            }

            $user->save();
            return $this->redirect(['user/index','user' => $user]);
        }
        return $this->render('index',[
            'user' => $user
        ]);
    }
}