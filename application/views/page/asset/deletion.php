<main class="c-main">
    <div class="container-fluid">
        <div id="ui-view">
            <div>
                <div class="fade-in">
                    <?php if ($this->session->level != 1) { ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <?php echo $page_title ?>


                                    </div>
                                    <div class="card-body">
                                        <?php if ($this->session->flashdata('alert') !== null) echo $this->session->flashdata('alert') ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <?php $this->load->view($page_current . '/form_deletion') ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">Dokumen</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mt-1">
                                                    <div class="col-12"><a target="_blank" href="<?php echo site_url('printdoc/usulan') ?>" class="btn btn-block btn-primary">Dokumen Pemusnahan</a></div>
                                                </div>
                                                <div class="row mt-1">
                                                    <div class="col-12"><a target="_blank" href="<?php echo site_url('printdoc/keterangan') ?>" class="btn btn-block btn-primary">Surat Keterangan</a></div>
                                                </div>
                                                <div class="row mt-1">
                                                    <div class="col-12"><a target="_blank" href="<?php echo site_url('printdoc/lampiran') ?>" class="btn btn-block btn-primary">Lampiran Gambar</a></div>
                                                </div>
                                                <div class="row mt-1">
                                                    <div class="col-12"><a target="_blank" href="<?php echo site_url('printdoc/lampiran/aset') ?>" class="btn btn-block btn-primary">Lampiran Aset</a></div>
                                                </div>
                                                <div class="row mt-1">
                                                    <div class="col-12"><a target="" href="<?php echo site_url('asset/document') ?>" class="btn text-white btn-block btn-warning">Upload Dokumen</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($document) && $document != null) { ?>

                                            <div class="row mt-3">
                                                <div class="col-12">
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
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php } else { ?>


                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        Dokumen
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if (isset($document) && $document != null) { ?>
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
                                        <?php
                                        }
                                        ?>
                                        <div class="col-12">
                                            <a href="<?php echo site_url('asset/deletion_accept/'.$agency_id) ?>" class="btn btn-warning btn-block text-white">Telah Diperiksa</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    Aset yang sedang diajukan
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-12 mt-4">
                                            <?php $this->load->view('page/asset/table_deletion') ?>
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