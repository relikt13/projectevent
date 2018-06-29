<?php

use yii\helpers\Url;
use yii\helpers\Html;
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
                            <a class="nav-link active" href="<?= Url::to(['page/album','slug'=>$page->slug])?>">Альбом мероприятия</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['page/opinion','slug'=>$page->slug])?>">Обсуждение</a>
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
                    if(Yii::$app->user->identity->id == $page->user_id){
                        ?>
                        <div class="col-md-7 center">
                            <div class="row">
                            <?php $form = ActiveForm::begin(); ?>

                            <?= $form->field($newImage, 'image')->fileInput() ?>
                            <div class="form-group">
                                <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                            </div>
                            </div>

                            <?php ActiveForm::end(); ?>


                        </div>
                        <?php
                    }
                    ?>
                    <div class="row">
                        <?php
                        //print_r($images);
                        foreach ($images as $image):
                        ?>
                        <div class="col-lg-3 col-md-4 col-6 thumb">
                            <a data-fancybox="gallery" href="/<?=$image->image?>">
                                <img class="img-fluid" src="/<?=$image->image?>" alt="<?=$image->content?>">
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>




            </div>


        </div>
    </div>

</main>

