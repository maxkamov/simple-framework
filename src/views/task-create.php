<?php

use app\core\form\Form;

?>


<?php $form = Form::begin('', 'post') ?>

<div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-6">
        <?php echo $form->field($model, 'username') ?>
        <?php echo $form->field($model, 'email') ?>
        <?php echo $form->field($model, 'text') ?>
        <button class="btn btn-success btn-block">Сохранить</button>
    </div>
</div>

<?php Form::end() ?>