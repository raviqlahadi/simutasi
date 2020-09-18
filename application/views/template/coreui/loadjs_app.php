 <!-- CoreUI and necessary plugins-->
 <script src="<?php echo base_url() .  COREUI_PATH  ?>js/coreui.bundle.min.js"></script>
 <script type="text/javascript" src="<?php echo base_url() . '/assets/' ?>js/jquery-3.5.1.min.js"></script>
 <?php
    if (isset($view_library) && array_search('datatable', $view_library) !== false) {
    ?>
     <script type="text/javascript" src="<?php echo base_url() . '/assets/' ?>DataTables/datatables.min.js"></script>
     <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>

     <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
     <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
     <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
     <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
     <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

 <?php
        $this->load->view('page/report/datatable_config');
    }
    ?>
 <?php
    if (isset($view_library) && array_search('ckeditor', $view_library) !== false) {
        $this->load->view('page/setting/ckeditor_config');
    }
    ?>