<?php
use yii\helpers\Url;
?>

<div class="container">
    <br>
    <label"><?=$form?></label>
    <br>

    <table class="table table-striped col">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">User name</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i=0;
        foreach ($userforms as $userform):
            $i++;
            ?>
        <tr>
            <th scope="row"><?=$i?></th>
            <td><?=$userform->user_name?></td>
            <td><a class="btn btn-outline-secondary" href="<?= Url::to(['form/show','id'=>$userform->id])?>">Просмотреть</a></td>

        </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>


</div>