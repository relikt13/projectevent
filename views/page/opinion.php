<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $page->title;
//var_dump($page);
?>
<main role="main">


    <div class="album py-5 bg-light">
        <div class="container">
            <div class="text-center">
                <h1><?=$page->title?></h1>
            </div>
            <div class="card text-center">

                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['page/about','slug'=>$page->slug])?>">Описание</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['page/album','slug'=>$page->slug])?>">Альбом мероприятия</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= Url::to(['page/opinion','slug'=>$page->slug])?>">Обсуждение</a>
                        </li>
                        <?php
                        if(Yii::$app->user->identity->id == $page->user_id){
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Url::to(['page/update','slug'=>$page->slug])?>">Редактировать</a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="card-body">


                        <?php
                        foreach ($opinions as $opinion):
                        ?>
                        <div class="card col-md-8 " style="margin: auto">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="<?= User::getAvatar($opinion->user_id)?>" class="img-fluid" alt="Responsive image">
                                    <h6><?= User::getLogin($opinion->user_id)?>: <?=$opinion->date?></h6>

                                </div>

                                <div class="col-md-9 text-left">
                                    <?=$opinion->content?>
                                </div>

                            </div>
                        </div>
                        <br>
                        <?php
                        endforeach;
                        ?>





                    <?php
                    if (!Yii::$app->user->isGuest) {
                        $form = ActiveForm::begin(); ?>

                        <?= $form->field($newOpinion, 'content')->textarea(['rows' => 3]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php
                        ActiveForm::end();
                    }?>
                </div>
            </div>


        </div>
    </div>

</main>