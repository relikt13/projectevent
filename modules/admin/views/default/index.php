<?php
use yii\helpers\Url;
?>

<table class="table">
    <thead class="thead-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Active</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($pages as $key=> $page):
    ?>
    <tr>
        <th scope="row"><?=$key+1?></th>
        <td><?=$page->title?></td>
        <td><?=$page->description?></td>
        <td><a class="btn btn-primary" href="<?= Url::to(['activ','id'=>$page->id]) ?>">Активировать</a></td>
    </tr>
    <?php
    endforeach;
    ?>

    </tbody>
</table>