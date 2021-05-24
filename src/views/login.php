<?php

use app\core\form\Form;

?>

<?php $form = Form::begin('', 'post') ?>
<div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-6">
        <?php echo $form->field($model, 'username') ?>
        <?php echo $form->field($model, 'password')->passwordField() ?>
        <button class="btn btn-success btn-block">Логин</button>
    </div>
</div>
<?php Form::end() ?>



