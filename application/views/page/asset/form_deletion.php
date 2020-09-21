  <?php
    if (isset($validation_error) && $validation_error !== null) echo $validation_error; ?>
  <form class="" action="<?php echo $form_action ?>" method="post" enctype="multipart/form-data">
      <div class="row">
          <div class="col-lg-12 px-5">
              <div class="form-group row">
                  <?php echo $this->form_template->select('Pilih Aset', 'asset_id', $assets_select, (isset($form_value)) ? $form_value['asset_id'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->select('Alasan', 'reason', $reason_select, (isset($form_value)) ? $form_value['reason'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->number('Depresiasi Aset', 'depreciation', 'Masukan nilai', (isset($form_value)) ? $form_value['depreciation'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->file('Dokumentasi', 'image') ?>
              </div>
              <div class="form-group row">
                  <button class='btn btn btn-warning text-white' type='submit'> Ajukan Penghapusan</button>
              </div>
          </div>

      </div>

  </form>