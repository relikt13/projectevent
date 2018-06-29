<?php

namespace app\controllers;

use app\models\Category;
use app\models\Page;
use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $date = "'".date('Y-m-d')."'";
//        var_dump($date);
        $query = Page::find()->where("`date` >= $date AND `active` = 1")->orderBy('date');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>6]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionCategory($slug)
    {
        $date = "'".date('Y-m-d')."'";
        $category = Category::findOne(['slug'=>$slug]);
        $query = Page::find()->where("`date` >= $date AND `category_id` = $category->id AND `active` = 1")->orderBy('date');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>6]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionMyproject($login)
    {
        if(Yii::$app->user->isGuest){
            return $this->render('/site/error',[
                'message'=>'403'
            ]);
        }
        $user = User::findOne(['login'=>$login]);
        $query = Page::find()->where(['user_id' => $user->id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>6]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister(){

        $model = new User();
        if($model->load(Yii::$app->request->post())){
            $model->password = Yii::$app->security->generatePasswordHash($model->password);
           // var_dump($model);die();
            $model->save();
            $this->redirect(['/site/login']);
        }
        return $this->render('register',
            ['model'=>$model]

        );
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionMylay(){
        $models  = (new Query())->select('*')->from('lay')
                                          ->join('INNER JOIN','page','lay.page_id=page.id')
                                          ->where(['lay.user_id'=>Yii::$app->user->identity->id])->all();
        //print_r($models);
        return $this->render('lay',[
            'models'=>$models
        ]);
    }
}
