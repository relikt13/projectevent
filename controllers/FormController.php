<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.05.2018
 * Time: 21:21
 */

namespace app\controllers;


use app\models\Formanswer;
use app\models\Formline;
use app\models\Formtable;
use app\models\Page;
use app\models\Userform;
use Yii;
use yii\web\Controller;

class FormController extends Controller
{
    public function actionCreate($id){

            if (Yii::$app->request->isPost) {
                $post = Yii::$app->request->post();

                if (!empty($post['name'])) {
                    $table = new Formtable();
                    $table->page_id = $id;
                    if ($post['to_guest'] === 'on') {
                        $table->to_guest = 0;
                    } else {
                        $table->to_guest = 1;
                    }
                    $table->title = $post['name'];
                    $table->save();
                }
                $annat = $post['annatation'];
                $select = $post['selected'];
                foreach ($annat as $key => $value) {
                    $line = new Formline();
                    $line->form_id = $table->id;
                    $line->annotation = $value;
                    $line->type = $select[$key];
                    $line->save();
                }
                $page = Page::findOne($id);
                return $this->redirect(['page/update', 'slug' => $page->slug]);

            }
            $form = new Formtable();
            return $this->render('create');

    }

    public function actionAnswer($id){
        $lines = Formline::find()->where(['form_id'=>$id])->all();
        $form  = Formtable::findOne($id);
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post('answer');
            $slug = Page::findOne($form->page_id);
            $slug = $slug->slug;
            $userform = new Userform();
            $userform->form_id = $id;
            if(Yii::$app->user->isGuest){
                $userform->user_name = 'Guest';
            } else{
                $userform->user_name = Yii::$app->user->identity->login;
            }
            $userform->save();
            foreach ($post as $key=>$value){
                $answer = new Formanswer();
                $answer ->line_id =$key;
                $answer->value = $value;
                $answer->userform_id = $userform->id;
                $answer->save(false);
            }
            return $this->redirect(['page/about','slug'=>$slug]);
        }

        return $this->render('answer',[
            'lines'=>$lines,
            'form'=>$form
        ]);
    }


    public function actionTable($id){
        $form  = Formtable::findOne($id);
        $userforms = Userform::find()->where(['form_id'=>$id])->all();
        return $this->render('table',[
           'userforms'=>$userforms,
            'form'=>$form->title,
        ]);
    }

    public function actionShow($id){

        $answers = Formanswer::find()->where(['userform_id'=>$id])->all();

        $lines = [];
        foreach ($answers as $answer){
            $lines[] = Formline::find()->where(['id'=>$answer->line_id])->one();
        }
        return $this->render('show',[
            'lines'=>$lines,
            'answers'=>$answers
        ]);
    }

}