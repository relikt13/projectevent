<?php
?>
<div class="album py-5 bg-light">
    <div class="container">
        <h3 class="text-center"><?=$form->title?></h3>
        <div class="card ">
            <form action="" method="post" name="Form">
                <input type="hidden" name="_csrf" value="<?= \Yii :: $app->getRequest()->getCsrfToken()?>">
                <?php
                    foreach ($lines as $line):

                        switch ($line->type){
                case 'text':
                        ?>
                <div class="col">
                    <br>
                    <label> <?=$line->annotation?></label>
                    <br>
                    <input type="text" class="col-md-7" name="answer[<?=$line->id?>]" cols="50" placeholder="<?=$line->annotation?>">
                </div>
                <?php
                        break;
                case 'chek':
                ?>
                    <div class="col">
                        <br>
                        <input type="checkbox" name="answer[<?=$line->id?>]">
                        <label> <?=$line->annotation?></label>

                    </div>
                <?php
                    break;
                    }

                endforeach;
                ?>
                <br>
                <button  class="col-md-2 btn-success" type="submit">Отправить</button>
            </form>
        </div>
    </div>
</div>

