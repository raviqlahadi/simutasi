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
                                                     <span>Template Laporan Bebas Aset</span>
                                                     <a href="<?php echo site_url('setting/template_edit')?>" class="float-right text-primary"><i class="fa fa-edit"></i> Edit</a>
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