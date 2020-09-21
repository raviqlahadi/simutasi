 <main class="c-main">
     <div class="container-fluid">
         <div id="ui-view">
             <div>
                 <div class="fade-in">
                     <div class="row">
                         <div class="col-12">
                             <div class="card">
                                 <div class="card-header">Setting</div>
                                 <div class="card-body">
                                     <div class="row">
                                         <div class="col-12">
                                             <?php if ($this->session->flashdata('alert') !== null) echo $this->session->flashdata('alert') ?>
                                         </div>
                                         <div class="col-12">
                                             <ul class="list-group">
                                                 <li class="list-group-item">
                                                     <span>Template Dokumen Usulan Penghapusan</span>
                                                     <a href="<?php echo site_url('setting/template_edit/usulan') ?>" class="float-right text-primary"><i class="fa fa-edit"></i> Edit</a>
                                                 </li>
                                                 <li class="list-group-item">
                                                     <span>Template Surat Keterangan</span>
                                                     <a href="<?php echo site_url('setting/template_edit/keterangan') ?>" class="float-right text-primary"><i class="fa fa-edit"></i> Edit</a>
                                                 </li>
                                                 <li class="list-group-item">
                                                     <span>Lampiran Gambar</span>
                                                     <a href="<?php echo site_url('setting/template_edit/lampiran_gambar') ?>" class="float-right text-primary"><i class="fa fa-edit"></i> Edit</a>
                                                 </li>

                                             </ul>
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