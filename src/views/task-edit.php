<?php

use app\core\form\Form;

?>


<?php $form = Form::begin('', 'post') ?>

    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <?php echo $form->hiddenField($model, 'id') ?>
            <?php echo $form->field($model, 'username',['readonly'=>true]) ?>
            <?php echo $form->field($model, 'email',['readonly'=>true]) ?>

            <?php echo $form->field($model, 'text') ?>
            <?php echo $form->checkboxField($model, 'status',
                "<div class=\"form-group {{errorClass}}\">
                                {{input}}
                                <label class=\"form-check-label\" for=\"defaultCheck1\">отметить как выполненное</label>
                                <div class=\"invalid-feedback text-danger\">
                                    {{errorMessage}}
                                </div>
                            </div>");
            ?>

            <button class="btn btn-success">Submit</button>
        </div>
    </div>


<?php Form::end() ?>