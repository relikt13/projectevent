<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\assets\WebAsset;
use yii\helpers\Url;

WebAsset::register($this);
$categories = Category::find()->all();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
   

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample04">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Главная</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="http://example.com" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Категории</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <?php
                        foreach ($categories as $category):
                        ?>
                        <a class="dropdown-item" href="<?=Url::to(['site/category','slug'=>$category->slug])?>"><?=$category->name ?></a>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </li>
            </ul>
        </div>

        <div class="col-md-offset-6">
            <?php
            if (Yii::$app->user->isGuest) {
                ?>
                <a class="btn btn-secondary" href="<?= Url::to(['site/login']) ?>">Login</a>
                <a class="btn btn-secondary" href="<?= Url::to(['site/register']) ?>">Register</a>
                <?php
            }else {
                ?>
                <div class="row">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?=Yii::$app->user->identity->login?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item"  href="<?= Url::to(['user/index'])?>">Личный кабинет</a>
                            <a class="dropdown-item"  href="<?= Url::to(['page/create'])?>">Новое событие</a>
                            <a class="dropdown-item"  href="<?= Url::to(['site/myproject','login'=>Yii::$app->user->identity->login])?>">Мои проекты</a>
                            <a class="dropdown-item"  href="<?= Url::to(['site/mylay'])?>">Закладки</a>
                            <a class="dropdown-item"  href="<?= Url::to(['site/logout'])?>">Выйти</a>
                        </div>
                    </div>


                    <?php
                    if(empty(Yii::$app->user->identity->image)|| !file_exists(Yii::$app->user->identity->image)) {
                        ?>
                        <img class="card-img-right flex-auto d-none d-lg-block"
                             data-src="holder.js/200x250?theme=thumb"
                             style="width: 50px; height: 100%;" src="/upload/noimage/noavat.jpg"
                             data-holder-rendered="true">
                        <?php
                    }else {
                        ?>
                        <img class="card-img-right flex-auto d-none d-lg-block"
                             data-src="holder.js/200x250?theme=thumb"
                             style="width: 50px; height: 100%;" src="/<?=Yii::$app->user->identity->image ?>"
                             data-holder-rendered="true">
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <p>

        </p>
    </nav>
    <div role="main" class="application main">
    <div class="container">
        <?= $content ?>
    </div>
    </div>
</div>

<footer class="footer bg-dark text-white">
    <div class="container ">
        <span class="text-muted">Relikt create by Yii2</span>
    </div>
</footer>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
