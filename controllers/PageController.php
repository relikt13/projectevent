<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.04.2018
 * Time: 23:03
 */

namespace app\controllers;


use app\models\Category;
use app\models\Formtable;
use app\models\Image;
use app\models\Lay;
use app\models\Opinion;
use app\models\Page;
use app\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\UploadedFile;

class PageController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionAbout($slug){
        $page = Page::findOne(['slug'=>$slug]);
        if(Yii::$app->user->isGuest){
            $forms = Formtable::find()->where(['page_id' => $page->id,'to_guest'=> 1])->all();
        }else {
            $forms = Formtable::find()->where(['page_id' => $page->id])->all();
        }
        $lay = Lay::findOne(['page_id'=>$page->id,'user_id'=>Yii::$app->user->identity->id]);
        if(isset($lay)){
            $lay = true;
        } else{
            $lay = false;
        }
        return $this->render('about',[
            'page'=>$page,
            'lay'=>$lay,
            'forms'=>$forms
        ]);
    }

    public function actionAlbum($slug){
        $page = Page::findOne(['slug'=>$slug]);
        $images = Image::find()->where(['page_id'=>$page->id])->all();
        $newImage = new Image();


        if ($newImage->load(Yii::$app->request->post()) ) {
            $image = UploadedFile::getInstance($newImage,'image');
            if(isset($image)){
            $filename = 'upload/images/'.Yii::$app->security->generateRandomString(10).'.'.$image->extension;
            $image->saveAs($filename);

            $newImage->image = $filename;
            $newImage->page_id = $page->id;
            $newImage->save();}
            return $this->redirect(['album', 'slug' => $page->slug]);
        }


        return $this->render('album',[
            'page'=>$page,
            'images'=>$images,
            'newImage'=> $newImage
        ]);
    }

    public function actionOpinion($slug){
        $page = Page::findOne(['slug'=>$slug]);
        $opinions = Opinion::find()->where(['page_id'=>$page->id])->all();
        $newOpinion = new Opinion();
        $users = ArrayHelper::map(User::find()->all(),'id','login');
        if ($newOpinion->load(Yii::$app->request->post())){
            $newOpinion->page_id = $page->id;
            $newOpinion->user_id = Yii::$app->user->identity->id;
            $newOpinion->save();
            $this->redirect(['page/opinion','slug'=>$slug]);
        }
        return $this->render('opinion',[
            'page'=>$page,
            'opinions'=>$opinions,
            'newOpinion'=>$newOpinion,
            'users'=>$users
        ]);
    }

    public function actionCreate(){
        if(Yii::$app->user->isGuest){
            return $this->render('/site/error',[
                'message'=>'404 page not found'
            ]);
        }
        $model = new Page();
        $category = ArrayHelper::map(Category::find()->all(),'id','name');

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->identity->id;
            if(empty($model->description)){
                $model->description = self::getDescriptionString($model->content);
            }
            $image = UploadedFile::getInstance($model, 'image');
            if(isset($image)) {
                $filename = 'upload/' . Yii::$app->security->generateRandomString(10) . '.' . $image->extension;
                $image->saveAs($filename);

                $model->image = $filename;
            }
            $model->slug = self::getTranslit($model->title);


            $model->save();
            return $this->redirect(['site/myproject','login'=>Yii::$app->user->identity->login]);
        }

        return $this->render('create', [
            'model' => $model,
            'category'=>$category
        ]);
    }

    public function actionUpdate($slug)
    {
        if(Yii::$app->user->isGuest){
            return $this->render('/site/error',[
                'message'=>'403'
            ]);
        }
        $page = Page::findOne(['slug'=>$slug]);
        $forms = Formtable::find()->where(['page_id'=>$page->id])->all();
        $way = Yii::getAlias('@web').$page->image;
        if ($page->load(Yii::$app->request->post()) ) {
            if (empty($page->description)){
                $page->description = self::getDescriptionString($page->content);
                }

            $image = UploadedFile::getInstance($page,'image');
            if(isset($image)) {
                $filename = 'upload/' . Yii::$app->security->generateRandomString(10) . '.' . $image->extension;
                $image->saveAs($filename);
                if (file_exists($way)) {
                    unlink($way);
                }
                $page->image = $filename;
            }
            $page->save(false);
            return $this->redirect(['about', 'slug' => $page->slug]);
        }

        return $this->render('update', [
            'page' => $page,
            'forms'=>$forms
        ]);
    }

    public static function getDescriptionString($str){
        $str = substr($str,0,100);
        $point = strrpos($str,'.') + 1;
        $str = substr($str,0,$point);
        return $str;
    }

    public static function getTranslit($s) {
        $s = (string) $s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
        $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }

    public function actionAddlay($id){
        if(Yii::$app->user->isGuest){
            return $this->render('/site/error',[
                'message'=>'403'
            ]);
        }
        $lay = new Lay();
        $page = Page::findOne(['id'=>$id]);
        $lay->page_id = $id;
        $lay->user_id = Yii::$app->user->identity->id;
        $lay->save();
        $this->redirect(['about','slug' => $page->slug]);
    }

    public function actionDellay($id){
        if(Yii::$app->user->isGuest){
            return $this->render('/site/error',[
                'message'=>'403'
            ]);
        }
        $lay = Lay::findOne(['page_id'=>$id,'user_id'=>Yii::$app->user->identity->id]);
        $page = Page::findOne(['id'=>$id]);

        $lay->delete();
        $this->redirect(['about','slug' => $page->slug]);
    }

}