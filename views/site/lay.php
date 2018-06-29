<?php

use app\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;



$this->title = 'Закладки';
$categories = ArrayHelper::map(Category::find()->all(),'id','name');
?>

<div class="album py-5 bg-light">
    <div class="container">

        <div class="row">

            <?php foreach ($models as $model):
                ?>
                <div class="col-md-6">
                    <div class="card flex-md-row mb-4 box-shadow h-md-250">
                        <div class="card-body d-flex flex-column align-items-start">
                            <strong class="d-inline-block mb-2 text-primary"><?=$categories[$model->category_id]?></strong>
                            <h3 class="mb-0">
                                <a class="text-dark" href="<?= Url::to(['page/about','slug'=>$model['slug']])?>"><?=$model['title']?></a>
                            </h3>
                            <div class="mb-1 text-muted"><?=$model['date']?></div>
                            <p class="card-text mb-auto"><?=$model['description']?></p>
                            <a href="<?= Url::to(['page/about','slug'=>$model['slug']])?>">Подрбнее...</a>
                        </div>
                        <?php
                        if(empty($model['image'])|| !file_exists($model['image'])) {
                            ?>
                            <img class="card-img-right flex-auto d-none d-lg-block"
                                 data-src="holder.js/200x250?theme=thumb"
                                 style="width: 200px; height: 100%;" src="/upload/noimage/no-images.jpg"
                                 data-holder-rendered="true">
                            <?php
                        }else {
                            ?>
                            <img class="card-img-right flex-auto d-none d-lg-block"
                                 data-src="holder.js/200x250?theme=thumb"
                                 style="width: 200px; height: 100%;" src="/<?= $model['image']?>"
                                 data-holder-rendered="true">
                            <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        </div>

    </div>

</div>

</main>