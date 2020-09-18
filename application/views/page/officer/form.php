<?php
if (isset($validation_error) && $validation_error !== null) echo $validation_error; ?>
<form class="" action="<?php echo $form_action ?>" method="post">
    <div class="form-group row">
        <?php echo $this->form_template->select('OPD', 'agency_id', $agency_select, (isset($form_value['agency_id'])) ? $form_value['agency_id'] : null, isset($agency_readonly) ? $agency_readonly : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->text('NIP', 'nip', 'masukan nip disini', (isset($form_value['nip'])) ? $form_value['nip'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->text('Nama ASN', 'full_name', 'masukan nama asn disini', (isset($form_value['full_name'])) ? $form_value['full_name'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->text('Pangkat/Golongan', 'rank', 'masukan pangkat / golongan disini', (isset($form_value['rank'])) ? $form_value['rank'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->radio('Jenis Kelamin', 'gender', $gender_option, (isset($form_value['gender'])) ? $form_value['gender'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->select('Agama', 'religion', $religion_select, (isset($form_value['religion'])) ? $form_value['religion'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->text('Bagian', 'section', 'masukan bagian disini', (isset($form_value['section'])) ? $form_value['section'] : null) ?>
    </div>
    <div class="form-group row">
        <?php echo $this->form_template->text('Jabatan', 'position', 'masukan jabatan disini', (isset($form_value['position'])) ? $form_value['position'] : null) ?>
    </div>


    <div class="form-group row">
        <?php echo $this->form_template->submit() ?>
    </div>

</form>