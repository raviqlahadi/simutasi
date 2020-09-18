<?php
if (isset($validation_error) && $validation_error !== null) echo $validation_error; ?>
<form class="" action="<?php echo $form_action ?>" method="post">
    <div class="form-group row">
        <?php echo $this->form_template->text('User Name', 'username', 'add name here', (isset($form_value)) ? $form_value['username'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->email('Email', 'email', 'add email here', (isset($form_value)) ? $form_value['email'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->select('OPD', 'agency_id', $agencies_select, (isset($form_value)) ? $form_value['agency_id'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->select('User Level', 'group_id', $group_select, (isset($form_value)) ? $form_value['group_id'] : null) ?>
    </div>

    <?php
    if (!isset($edit) || !$edit) {
    ?>
        <div class="form-group row">
            <?php echo $this->form_template->password('Password', 'password', 'add password here', (isset($form_value)) ? $form_value['password'] : null) ?>
        </div>
        <div class="form-group row">
            <?php echo $this->form_template->password('Confirm Password', 'password_confirm', 'confirm the password', (isset($form_value)) ? $form_value['password_confirm'] : null) ?>
        </div>
    <?php
    }
    ?>
    <div class="form-group row">
        <?php echo $this->form_template->submit() ?>
    </div>

</form>