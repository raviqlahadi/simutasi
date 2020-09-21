<?php 
class Table_template 
{
    public function action_dropdown($url, $id, $edit_url=null)
    {
        if($edit_url!=null){
            $edit = "<a class='dropdown-item' href='" . $edit_url . "'>Edit</a>";
        }else{
            $edit = " <a class='dropdown-item' href='" . $url . "/edit/" . $id . "'>Edit</a>";
        }
        return "
            <div class='dropdown'>
                <button class='btn btn-warning text-white btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    Action
                </button>
                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                    ".$edit."
                    <a class='dropdown-item text-danger' href='" . $url . "/delete/" . $id . "'>Delete</a>
            </div>
        ";
    }

    public function action_dropdown_officer($url, $id, $print=false, $edit_url = null)
    {
        $modal = '';
        if($print){
            $action = " <a class='dropdown-item'  data-toggle='modal' data-target='#exampleModal".$id."'>Print Bebas Aset</a>";
            $modal = "<div class='modal fade' id='exampleModal" . $id . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Print Dokumen Bebas Aset</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <form action='" . site_url() . "printdoc/index/" . $id . "' method='get'>
                                    <div class='form-group'>
                                        <label class='col-form-label' for='perihal'>Keterangan</label>
                                        <input class='form-control' id='perihal' type='text' name='perihal' placeholder='Keterangan' >
        
                                    </div>
                                    <div class='form-group'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                        <button type='submit' class='btn btn-warning text-white'>Save changes</button>
                                    </div>
                                </form>
                            </div>
                           
                            </div>
                        </div>
                    </div>";
        }else{
            $action = " <a class='dropdown-item' href='" . $url . "/asset/" . $id . "'>Penguasaan Aset</a>";
            
        }
        if ($edit_url != null) {
            $edit = "<a class='dropdown-item' href='" . $edit_url . "'>Edit</a>";
        } else {
            $edit = " <a class='dropdown-item' href='" . $url . "/edit/" . $id . "'>Edit</a>";
        }
        
        return "
            <div class='dropdown'>
                <button class='btn btn-warning text-white btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    Action
                </button>
                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                    " . $action . "
                    <hr>
                    " . $edit . "
                    <a class='dropdown-item text-danger' href='" . $url . "/delete/" . $id . "'>Delete</a>
            </div>
            ".$modal."
        ";
    }

    public function action_dropdown_asset($url, $id, $with_edit_delete=false)
    {   
            if($with_edit_delete){
                $edit_delete = "
                <a class='dropdown-item' href='" . $url . "/edit/" . $id . "'>Edit</a>
                <a class='dropdown-item text-danger' href='" . $url . "/delete/" . $id . "'>Delete</a>";
            }else{
                $edit_delete = "";
            }
            return "
            <div class='dropdown'>
                <button class='btn btn-warning text-white btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    Action
                </button>
                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>                 
                    <a class='dropdown-item' href='" . $url . "/detail/" . $id . "'>Detail</a>
                    ". $edit_delete. "
            </div>
        ";
    }

    

    public function badge($type){
        switch ($type) {
            case 'digunakan':
                $return = 'info';
                break;
            case 'verifikasi':
                $return = 'warning';
                break;
            case 'dikembalikan':
                $return = 'success';
                break;
            default:
                $return = 'primary';
                break;
        }
        return $return;
    }

    public function set_pagination($pagination)
    {
        
        
        $config['base_url'] = $pagination['base_url'];
        $config['total_rows'] = $pagination['total_records'];
        $config['per_page'] = $pagination['limit_per_page'];
        $config["uri_segment"] = $pagination['uri_segment'];

        // custom paging configuration
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        
        // build paging links
        return $config;
    }
}
    
?>