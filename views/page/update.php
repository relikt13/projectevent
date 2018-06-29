<?php

use app\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

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
                            <a class="nav-link" href="<?= Url::to(['page/opinion','slug'=>$page->slug])?>">Обсуждение</a>
                        </li>
                        <?php
                        if(Yii::$app->user->identity->id == $page->user_id){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= Url::to(['page/update','slug'=>$page->slug])?>">Редактировать</a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="container">
                            <div align="left" class="row" >
                                <a style="margin-left: 10px" class="btn btn-primary " href="<?= Url::to(['form/create', 'id' => $page->id]) ?>">Добавить форму заявки</a>
                                <button style="margin-left: 10px" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ответы
                                </button>
                                <div class="dropdown-menu">
                                    <?php
                                    foreach ($forms as $form):
                                    ?>
                                        <a class="dropdown-item"  href="<?= Url::to(['form/table','id'=>$form->id])?>"><?=$form->title?></a>
                                    <?php
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                            <?php
                            $category = ArrayHelper::map(Category::find()->all(),'id','name');
                            ?>

                            <div class="center">

                                <?php $form = ActiveForm::begin(); ?>

                                <?= $form->field($page, 'description')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($page, 'content')->textarea(['rows' => 6]) ?>

                                <?= $form->field($page, 'image')->fileInput() ?>

                                <?= $form->field($page, 'category_id')->dropDownList($category,['prompt'=>'выбор категории']) ?>

                                <?= $form->field($page, 'date')->textInput() ?>

                                <div class="form-group">
                                    <?= Html::submitButton('Обновить', ['class' => 'btn btn-success']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>


                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</main>