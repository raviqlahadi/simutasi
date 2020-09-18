<?php
if (isset($validation_error) && $validation_error !== null) echo $validation_error; ?>
<form class="" action="<?php echo $form_action ?>" method="post">

        <div class="form-group row">
            <?php echo $this->form_template->password('Password', 'password', 'add password here', (isset($form_value)) ? $form_value['password'] : null) ?>
        </div>
        <div class="form-group row">
            <?php echo $this->form_template->password('Confirm Password', 'password_confirm', 'confirm the password', (isset($form_value)) ? $form_value['password_confirm'] : null) ?>
        </div>
   
    <div class="form-group row">
        <?php echo $this->form_template->submit() ?>
    </div>

</form>