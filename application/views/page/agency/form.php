<?php
if (isset($validation_error) && $validation_error !== null) echo $validation_error; ?>
<form class="" action="<?php echo $form_action ?>" method="post">
    <div class="row">
        <div class="col-lg-6 px-5">
            <div class="form-group row">
                <?php echo $this->form_template->text('Kode OPD', 'code', 'masukan kode instansi disini', (isset($form_value)) ? $form_value['code'] : null) ?>
            </div>
            <div class="form-group row">
                <?php echo $this->form_template->text('Nama OPD', 'name', 'masukan nama instansi disini', (isset($form_value)) ? $form_value['name'] : null) ?>
            </div>
            <div class="form-group row">
                <?php echo $this->form_template->text('Kementrian', 'ministry', 'masukan nama kementrian disini', (isset($form_value)) ? $form_value['ministry'] : null) ?>
            </div>
            <div class="form-group row">
                <?php echo $this->form_template->select('Kepala Dinas', 'hod_id', $officers_select, (isset($form_value)) ? $form_value['hod_id'] : null) ?>
            </div>
            <div class="form-group row">
                <?php echo $this->form_template->select('Pejabat Aset', 'ao_id', $officers_select, (isset($form_value)) ? $form_value['ao_id'] : null) ?>
            </div>
            <div class="form-group row">
                <?php echo $this->form_template->text('Telepon', 'phone', 'masukan nomor telepon disini', (isset($form_value)) ? $form_value['phone'] : null) ?>
            </div>

        </div>
        <div class="col-lg-6  px-5">
            <div class="form-group row">
                <?php echo $this->form_template->text('Fax', 'fax', 'masukan fax disini', (isset($form_value)) ? $form_value['fax'] : null) ?>
            </div>
            <div class="form-group row">
                <?php echo $this->form_template->email('Email', 'email', 'masukan email disini', (isset($form_value)) ? $form_value['email'] : null) ?>
            </div>
            <div class="form-group row">
                <?php echo $this->form_template->text('Website', 'website', 'masukan website disini', (isset($form_value)) ? $form_value['website'] : null) ?>
            </div>
            <div class="form-group row">
                <?php echo $this->form_template->textarea('Alamat', 'address', 'masukan alamat disini', (isset($form_value)) ? $form_value['address'] : null) ?>
            </div>

        </div>
    </div>



    <div class="form-group row">
        <?php echo $this->form_template->submit() ?>
    </div>

</form>