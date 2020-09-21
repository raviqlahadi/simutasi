 <main class="c-main">
     <div class="container-fluid">
         <div id="ui-view">
             <div>
                 <div class="fade-in">
                     <div class="row">
                         <div class="col-12">
                             <div class="card">
                                 <div class="card-header">Edit Template</div>
                                 <div class="card-body">
                                     <div class="row">
                                         <div class="col-12">
                                             <?php if ($this->session->flashdata('alert') !== null) echo $this->session->flashdata('alert') ?>
                                         </div>
                                         <div class="col-12">
                                             <form action="<?php echo $form_action ?>" method="post"> 
                                                 <div class="row">
                                                     <div class="col-12">
                                                         <div class="form-group">
                                                             <input type="hidden" name="id" value="<?php echo $template_data->id ?>">
                                                             <textarea name="template" id="ckeditor" cols="30" rows="10"><?php echo $template_data->template ?></textarea>
                                                         </div>
                                                     </div>

                                                 </div>
                                                 <div class="row">
                                                     <div class="col-12">
                                                         <div class="form-group">
                                                             <button type="submit" class="btn btn-warning text-white float-right">Save Template</button>
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