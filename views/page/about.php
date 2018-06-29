<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

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
                            <a class="nav-link  active" href="<?= Url::to(['page/about','slug'=>$page->slug])?>">Описание</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['page/album','slug'=>$page->slug])?>">Альбом мероприятия</a>
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
                    if(!empty($page->image)&& file_exists($page->image)) {
                        ?>
                        <img src="/<?= $page->image ?>" class="img-fluid" alt="Responsive image">
                        <?php
                    }
                    ?>
                    <p><div class="row"">
                    <?php Pjax::begin();
                    if(!Yii::$app->user->isGuest) {
                    ?>
                    <div style="margin: 10px">
                        <?php if (!$lay) { ?>

                            <?= Html::a("Добавить в закладки", ['page/addlay', 'id' => $page->id], ['class' => 'btn btn-info'],['data-pjax'=>0]) ?>
                            <?php
                        } else {
                            ?>
                            <?= Html::a("Удалить
                                закладку", ['page/dellay', 'id' => $page->id], ['class' => 'btn btn-danger'],['data-pjax'=>0]) ?>
                            <?php
                        }
                        ?>
                    </div>
                    <?php

                    Pjax::end(); ?>
                    <div style="margin: 10px">
                        <?php if (!empty($forms)) { ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                Отправить заявку
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php
                                foreach ($forms as $form):?>

                                    <a class="dropdown-item"
                                       href="<?= Url::to(['form/answer', 'id' => $form->id]) ?>"><?= $form->title ?></a>


                                <?php
                                endforeach;
                                ?>
                            </div>
                            <?php
                            }
                            }
                            ?>
                    </div>
                    </div>
                    </p>
                    <p class="lead"><?=$page->content?></p>
                </div>
            </div>


        </div>
    </div>

</main>