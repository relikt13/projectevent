<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Opinion */

$this->title = 'Update Opinion: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Opinions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="opinion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
