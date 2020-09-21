 <main class="c-main">
     <div class="container-fluid">
         <div id="ui-view">
             <div>
                 <div class="fade-in">
                     <div class="row">
                         <div class="col-12">
                             <div class="fade-in">
                                 <div class="row">
                                     <div class="col-12">
                                         <div class="card bg-gradient-warning text-white" style="min-height: 100px;border-radius:.75rem">
                                             <div class="card-body">
                                                 <div class="row">
                                                     <div class="col-12">
                                                         <h3>
                                                             Selamat Datang! <span class="small"><?php echo $this->session->username ?></span>
                                                         </h3>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                <?php 
                                    if($this->session->level!=1){
                                        $this->load->view('page/dashboard/opd');
                                    }else{
                                    $this->load->view('page/dashboard/admin_asset');
                                    }
                                ?>
                                 <?php if ($this->session->flashdata('alert') !== null) echo $this->session->flashdata('alert') ?>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

         </div>
 </main>