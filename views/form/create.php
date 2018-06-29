<?php



?>


<div class="album py-5 bg-light">
    <div class="container">
        <div class="card">


            <form action="" method="post" name="Form">
                <div class="col">
                    <input type="checkbox" name="to_guest">
                    <label> Толко для зарегистрированных пользователей</label>
                </div>
                <div class="col" style="margin-bottom: 10px">

                    <input class="col-md-6" type="text" name="name" placeholder="имя формы" required>

                </div>
                 <div id="DynamicExtraFieldsContainer" >
                     <div id="addDynamicField">
                         <input type="button" id="addDynamicExtraFieldButton" value="Добавить поле">
                     </div>

                     <div class="forms">
                         <input type="hidden" name="_csrf" value="<?= \Yii :: $app->getRequest()->getCsrfToken()?>">
                         <div class="row DynamicExtraField" style="margin: 10px; margin-right: 10px">

                             <input type="text" class="col-md-7" name="annatation[]" cols="50" placeholder="Коммента́рии к полю" required>
                             <select name="selected[]" class="col-md-3">
                                 <option value="text">text</option>
                                 <option value="chek">chek</option>
                             </select>

                             <input value="X" type="button" class="DeleteDynamicExtraField btn btn-danger">
                          </div>
                      </div>
                    </div>
                 <br>

                <button type="submit">Создать форму</button>
            </form>
</div>
</div>
</div>





<?php $this->registerJs("

    $('#addDynamicExtraFieldButton').click(function(event) {
        addDynamicExtraField();
        return false;
    });

    function addDynamicExtraField() {
        var block = $('.DynamicExtraField').first().clone();

        block.find('.DeleteDynamicExtraField').on('click',function() {
            $(this).parent().remove();
        });
        $('.forms').append(block);

    }
    //Для удаления первого поля. если оно не динамическое
    $('.DeleteDynamicExtraField').click(function(event) {
        $(this).parent().remove();
        return false;
    });
");
?>