  <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-header">
                  Aset Yang Sedang Diajukan
                  <a class="btn btn-warning text-white float-right text-white" href="<?php echo site_url('asset/deletion'); ?>"><i class="fa fa-plus"></i> Tambah Pengajuan</a>
              </div>
              <div class="car-body">
                  <?php $this->load->view('page/dashboard/table') ?>
              </div>
          </div>
      </div>

  </div>
  <?php
    if (isset($document) && $document != null) { ?>

      <div class="row mt-3">
          <div class="col-12">
              <div class="card">
                  <div class="card-header">
                      Dokumen
                  </div>
                  <div class="card-body">
                      <table class="table table-bordered">
                          <tr>
                              <td><strong>Dokumen</strong></td>
                              <td><a href="<?php echo base_url('uploads/document/') . $document->name ?>" target="_blank"><?php echo $document->name ?></a></td>
                          </tr>
                          <tr>
                              <td><strong>Status</strong></td>
                              <td><span class="badge badge-primary"><?php echo $document->status ?></span></td>
                          </tr>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  <?php
    }
    ?>