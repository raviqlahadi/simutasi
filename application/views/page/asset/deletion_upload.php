<main class="c-main">
    <div class="container-fluid">
        <div id="ui-view">
            <div>
                <div class="fade-in">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <?php echo $page_title ?>
                                    <a class="btn btn-warning text-white float-right text-white" href="<?php echo $page_url; ?>"><i class="fa fa-arrow-circle-left"></i> Back</a>

                                </div>
                                <div class="card-body">
                                    <?php if ($this->session->flashdata('alert') !== null) echo $this->session->flashdata('alert') ?>
                                    <div class="row">
                                        <div class="col-4">
                                            <table class="table table-responsive-sm table-bordered table-striped">
                                                <tr>
                                                    <td>Kode Aset</td>
                                                    <td><?php echo $table_content->asset_code ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Aset</td>
                                                    <td><?php echo $table_content->type ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Merk</td>
                                                    <td><?php echo $table_content->brand ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor</td>
                                                    <td><?php echo $table_content->police_number ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-8">
                                            <?php
                                            if (isset($validation_error) && $validation_error !== null) echo $validation_error; ?>
                                            <form class="" action="<?php echo $form_action ?>" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-lg-12 px-5">
                                                        <div class="form-group row">
                                                            <?php echo $this->form_template->file('Dokumentasi', 'image') ?>
                                                        </div>
                                                        <div class="form-group float-right  row">
                                                            <button class='btn btn btn-warning text-white ' type='submit'> Upload Gambar</button>
                                                        </div>
                                                    </div>

                                                </div>

                                            </form>
                                        </div>

                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</main>