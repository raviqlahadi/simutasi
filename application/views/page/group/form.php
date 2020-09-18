<?php
 if (isset($validation_error) && $validation_error !== null) echo $validation_error; ?>
<form class="form-horizontal" action="<?php echo $form_action ?>" method="post">
    <div class="form-group row">
        <?php echo $this->form_template->text('Name', 'name', 'add name here',(isset($form_value)) ? $form_value['name'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->textarea('Description', 'description', 'add description here', (isset($form_value)) ? $form_value['description'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->submit() ?>
    </div>

</form>