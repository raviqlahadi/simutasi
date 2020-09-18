  <?php
    if (isset($validation_error) && $validation_error !== null) echo $validation_error; ?>
  <form class="" action="<?php echo $form_action ?>" method="post">
      <div class="row">
          <div class="col-lg-6 px-5">
              <div class="form-group row">
                  <?php echo $this->form_template->select('OPD', 'agency_id', $agency_select, (isset($form_value)) ? $form_value['agency_id'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('kode aset'), 'asset_code', 'masukan kode aset disini', (isset($form_value)) ? $form_value['asset_code'] : null) ?>
              </div>
              <div class="row">
                  <strong>
                      Informasi Dasar Aset
                  </strong>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('jenis aset'), 'type', 'masukan jenis aset disini', (isset($form_value)) ? $form_value['type'] : null) ?>

              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('merk'), 'brand', 'masukan merk disini', (isset($form_value)) ? $form_value['brand'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('tahun pembelian'), 'year_purchased', 'masukan tahun pembelian disini', (isset($form_value)) ? $form_value['year_purchased'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('warna'), 'color', 'masukan warna disini', (isset($form_value)) ? $form_value['color'] : null) ?>
              </div>

              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('harga aset'), 'price', 'masukan harga aset disini', (isset($form_value)) ? $form_value['price'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('asal'), 'origin', 'masukan asal disini', (isset($form_value)) ? $form_value['origin'] : null) ?>
              </div>

          </div>
          <div class="col-lg-6 px-5">
              <div class="row">
                  <strong>
                      Nomor
                  </strong>
              </div>

              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('rangka'), 'chassis_number', 'masukan nomor rangka disini', (isset($form_value)) ? $form_value['chassis_number'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('mesin'), 'machine_number', 'masukan nomor mesin disini', (isset($form_value)) ? $form_value['machine_number'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('polisi'), 'police_number', 'masukan nomor polisi disini', (isset($form_value)) ? $form_value['police_number'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->text(strtoupper('bpkd'), 'bpkb_number', 'masukan nomor bpkd disini', (isset($form_value)) ? $form_value['bpkb_number'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('pabrik'), 'factory_number', 'masukan nomor pabrik disini', (isset($form_value)) ? $form_value['factory_number'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('kode'), 'code_number', 'masukan nomor kode disini', (isset($form_value)) ? $form_value['code_number'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->text(ucwords('register'), 'register_number', 'masukan nomor register disini', (isset($form_value)) ? $form_value['register_number'] : null) ?>
              </div>


              <div class="form-group row">
                  <?php echo $this->form_template->textarea(ucwords('keterangan / kondisi'), 'description', 'masukan keterangan disini', (isset($form_value)) ? $form_value['description'] : null) ?>
              </div>

          </div>
          <div class="col-12 px-4">
              <div class="form-group row">
                  <?php echo $this->form_template->submit() ?>
              </div>
          </div>
      </div>





  </form>