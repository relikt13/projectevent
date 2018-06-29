<?php

namespace app\modules\admin\controllers;

use app\models\Page;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $pages = Page::find()->where(['active' => 0])->all();
        return $this->render('index',[
            'pages'=> $pages
        ]);
    }

    public function actionActiv($id){
        $page = Page::findOne($id);
        $page->active = 1;
       // var_dump($page);
        $page->save(false);
        return $this->redirect(['default/index']);
    }
}
