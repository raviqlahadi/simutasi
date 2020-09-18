<form class="" action="<?php echo $form_action ?>" method="post">
    <div class="form-group row">
        <?php echo $this->form_template->text('Telepon', 'phone', 'add phone here', (isset($form_value)) ? $form_value['phone'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->radio('Jenis Kelamin', 'gender', $gender_option, (isset($form_value)) ? $form_value['gender'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->text('Jabatan', 'position', 'add position here', (isset($form_value)) ? $form_value['position'] : null) ?>
    </div>



    <div class="form-group row">
        <?php echo $this->form_template->submit() ?>
    </div>

</form>