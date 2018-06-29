<?php

use app\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Новое событие';
?>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="card text-center">
            <div class="col-md-12" >




                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'image')->fileInput() ?>

                <?= $form->field($model, 'category_id')->dropDownList($category,['prompt'=>'выбор категории']) ?>


                <?= $form->field($model, 'date')->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>


            </div>
        </div>
    </div>
</div>
