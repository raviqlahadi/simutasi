  <?php
    if (isset($validation_error) && $validation_error !== null) echo $validation_error; ?>
  <form class="" action="<?php echo $form_action ?>" method="post">
      <div class="row">
          <div class="col-lg-12 px-5">
              <div class="form-group row">
                  <?php echo $this->form_template->select('ASN', 'officer_id', $officers_select, (isset($form_value)) ? $form_value['officer_id'] : null) ?>
              </div>
              <div class="form-group row">
                  <?php echo $this->form_template->select('Status', 'status', $status_select, (isset($form_value)) ? $form_value['status'] : null) ?>
              </div>
          </div>
          <div class="col-12 px-4">
              <div class="form-group row">
                  <?php echo $this->form_template->submit() ?>
              </div>
          </div>
      </div>





  </form>