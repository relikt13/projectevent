<?php
use yii\helpers\Url;
?>

<div class="container">
    <br>
    <label"><?=$form?></label>
    <br>

    <table class="table table-striped col">
        <tbody>
        <?php

        foreach ($lines as $key=>$line):
            ?>
            <tr>
                <th scope="row"><?=$line->annotation?></th>
                <td><?=$answers[$key]->value?></td>
            </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>


</div>