<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Профиль';
?>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="card text-center">
            <div class="row">
                <div class="col">
                    <?php
                    if(empty($user->image)|| !file_exists($user->image)) {
                        ?>
                        <img class="card-img-right flex-auto d-none d-lg-block thumb"
                             data-src="holder.js/200x250?theme=thumb"
                             style="width: 300px; height: 100%;" src="/upload/noimage/noavat.jpg"
                             data-holder-rendered="true">
                        <?php
                    }else {
                        ?>
                        <img class="card-img-right flex-auto d-none d-lg-block thumb"
                             data-src="holder.js/200x250?theme=thumb"
                             style="width: 450px" src="/<?= $user->image ?>"
                             data-holder-rendered="true">
                        <?php
                    }
                    ?>
                </div>

                <div class="col">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="col-md-6">
                        <?= $form->field($user, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($user, 'last_name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($user, 'image')->fileInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
