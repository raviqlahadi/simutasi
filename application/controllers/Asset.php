<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset extends MY_Controller
{
    private $url = 'asset';
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->check_access();

        $this->load->library('form_template');
        $this->load->library('table_template');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('breadcrumbs');
        
        $this->load->model('m_assets');
        $this->load->model('m_agencies');
        $this->load->model('m_deletions');
        $this->load->model('m_documents');
        
        
    }
    
    public function index()
    {


        //page config
        $limit = $this->input->get('limit');
        $limit_per_page = ($limit != null && $limit != '') ? $limit : 10;
        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
        $start_record = $page * $limit_per_page;        
        
        // table props, change this base on table props
        $data['table_head'] = array(
            'asset_code' => 'Kode Aset', 
            'type' => 'Jenis',
            'brand' => "Merk",
            'police_number' => "Nomor Polisi",
            'agency_name' => 'OPD'
        );

        $search = ($this->input->get('search') != null ) ? $this->input->get('search') : false ;        

        if($search){
            $fetch['like'] = array('name'=>array('asset_code','type','brand','police_number'), 'key'=>$search);
        }

        $fetch['select'] = array('id','asset_code', 'type', 'brand','police_number');
        $fetch['select_join'] = array(
            'a.name as agency_name');
        $fetch['join'] = array(
            array(
                "table" => "agencies a",
                "join" => "left",
                "on" => "a.id = assets.agency_id"
            )

        );
        $fetch['where'] = [];
        $fetch['start'] = $start_record;
        $fetch['limit'] = $limit_per_page;
        if($this->session->level!=1) array_push($fetch['where'], array('assets.agency_id'=> $this->session->agency_id));
        //var_dump($this->m_assets->fetch($fetch,false,true));
        $data['table_content'] = $this->m_assets->fetch($fetch);
        $total_records = $this->m_assets->fetch($fetch,true);


        //pagination config
        $pagination['base_url'] = site_url($this->url) . '/index';
        $pagination['limit_per_page'] = $limit_per_page;
        $pagination['start_record'] = $start_record;
        $pagination['uri_segment'] = 3;
        $pagination['total_records'] =  $total_records;
        $data['pagination'] = false;
        if ($pagination['total_records'] > 0){
            $config = $this->table_template->set_pagination($pagination);
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
        }


        //breadcrumbs config
        $this->breadcrumbs->push('Asset', '/asset');
        $this->breadcrumbs->unshift('Admin', '/');


        //page properties        
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Asset</strong> Management';
        $data['table_start_number'] = $start_record;
        $data['page_content'] = 'page/asset/index';
        $data['page_current'] = 'page/asset';
        $data['page_url'] = site_url($this->url);

        $this->load->view('index', $data);
    }

    
    public function create()
    {
        
        //breadcrumbs config
        $this->breadcrumbs->push('Asset', '/asset');
        $this->breadcrumbs->push('Create', '/create');
        $this->breadcrumbs->unshift('Admin', '/');

        //page props
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Add New</strong> Asset';
        $data['page_content'] = 'page/asset/create';
        $data['page_current'] = 'page/asset';

        //form props
        $data['form_title'] = "<strong>Add new</strong> Asset";
        $data['form_action'] = site_url($this->url.'/create');

        //select option
        $this->load->model('m_agencies');
        $agency_data = $this->m_agencies->fetch(array('select' => array('id', 'name')));
        $data['agency_select'] = $agency_data;

        if ($_POST) {
            $this->form_validation_rules();
            if ($this->form_validation->run() == FALSE) {
                $data['form_value'] = $this->input->post();
                $data['validation_error'] =  $this->alert->set_alert('warning', validation_errors());
            } else {
                $post_data = $this->input->post();               
                $this->add($post_data);                
            }
        }

        $data['page_url'] = site_url($this->url);
        $this->load->view('index', $data);
    }

    public function add($post_data)
    {
        if (array_key_exists('password_confirm', $post_data)) unset($post_data['password_confirm']);
        $insert = $this->m_assets->add($post_data);
        if ($insert) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di masukan ke database'));
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data gagal di masukan ke database'));
        }
        redirect($this->url);
    }

    public function deletion($agency_id=null)
    {
        //breadcrumbs config
        $this->breadcrumbs->push('Asset', '/asset');
        $this->breadcrumbs->push('Pemusnahan', '/deletion');
        $this->breadcrumbs->unshift('Admin', '/');


        //page props
        $data['table_head'] = array(
            'asset_code' => 'Kode Aset',
            'type' => 'Jenis',
            'brand' => "Merk",
            'police_number' => "Nomor Polisi",
            'chassis_number' => "Nomor Rangka",
            'price' => "Harga",
            'year_purchased' => "Tahun Pembelian",
           
        );

        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Pemusnahan</strong> Aset';
        $data['page_content'] = 'page/asset/deletion';
        $data['page_current'] = 'page/asset';

        
        //asset remove list
        $fetch['select'] = array('*');
        $fetch['select_join'] = array('d.id as status_id, d.reason, d.status, d.image, d.depreciation');
        $fetch['join'] = array(
            array(
                "table" => "asset_deletions d",
                "join" => "join",
                "on" => "d.asset_id = assets.id"
            ),
        );
        $fetch['where'] = [];

        if($agency_id==null) $agency_id = $this->session->agency_id;
        
        array_push($fetch['where'],array('assets.agency_id'=>$agency_id));
        $data['table_content'] = $this->m_assets->fetch($fetch);

        //form props
        $data['form_title'] = "<strong>Pemusnahan</strong> Aset";
        $data['form_action'] = site_url($this->url . '/deletion/');


        //select option
        $fetch_select['select'] = array('id', 'type', 'asset_code', 'brand', 'police_number');
        $fetch_select['where'] = [];
        array_push($fetch_select['where'], array('assets.agency_id' => $agency_id));

        $temp_assets = $this->m_assets->fetch($fetch_select);
        $assets = array();
        foreach ($temp_assets as $key => $value) {
           array_push($assets, array(
               'id'=>$value->id,
               'name'=>$value->asset_code.' '.$value->brand.' - '.$value->type.' - '.$value->police_number
           ));
        }
        
        $data['assets_select'] = $assets;
        $data['reason_select'] = array(
            array('id' => 'rusak berat', 'name' => 'rusak berat'),
            array('id' => 'hilang', 'name' => 'hilang'),
            array('id' => 'dikuasai pihak lain', 'name' => 'dikuasai pihak lain'),
            
        );

        //get document
        $document = $this->m_documents->getWhere(array('agency_id'=>$agency_id,'status'=>'diajukan'));
        if(count($document)>0){
            $data['document'] = $document[0];
        }

        if ($_POST) {
            $this->form_status_validation_rules();
            if ($this->form_validation->run() == FALSE) {
                $data['form_value'] = $this->input->post();
                $data['validation_error'] =  $this->alert->set_alert('warning', validation_errors());
            } else {
                $post_data = $this->input->post();

                $config = $this->upload_config($post_data['asset_id']);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    $error = array('error' => $this->upload->display_errors());
                    $post_data['image'] = null;
                    $this->session->set_flashdata('alert', $this->alert->set_alert('danger', json_encode($error)));
                
                } else {
                   $this->session->set_flashdata('alert', $this->alert->set_alert('info','upload berhasil'));
                   $post_data['image'] = $this->upload->data('file_name'); ;
                }
                $this->add_deletion($post_data);
            }
        }

        $data['page_url'] = site_url($this->url);
        $data['agency_id'] = $agency_id;
        $data['view_library'] = array('select2');
        $this->load->view('index', $data);
    }

    public function deletion_image($id){
        if($id==null) redirect($this->url . '/deletion');
       
        $check_id = $this->m_deletions->getWhere(array('id'=>$id));
        if(count($check_id)==0) redirect($this->url . '/deletion');
        $asset_data = $this->m_assets->getWhere(array('id' => $check_id[0]->asset_id));

        //breadcrumbs config
        $this->breadcrumbs->push('Asset', '/asset');
        $this->breadcrumbs->push('Pemusnahan', '/asset/deletion');
        $this->breadcrumbs->push('Upload', '/deletion_image');
        $this->breadcrumbs->unshift('Admin', '/');


        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Pemusnahan</strong> Aset';
        $data['page_content'] = 'page/asset/deletion_upload';
        $data['page_current'] = 'page/asset';
        $data['table_content'] = $asset_data[0];

        //form props
        $data['form_title'] = "<strong>Pemusnahan</strong> Aset";
        $data['form_action'] = site_url($this->url . '/deletion_upload/'.$id);

        $data['page_url'] = site_url($this->url);
        $this->load->view('index', $data);
    }

    public function deletion_accept($agency_id){
        $deletion_data = $this->m_deletions->getWhere(array('agency_id'=>$agency_id, 'status'=>'diajukan'));
        foreach ($deletion_data as $key => $value) {
            $data['status'] = 'diperiksa';
            $this->m_deletions->update($value->id, $data);
        }

        $document_data = $this->m_documents->getWhere(array('agency_id' => $agency_id, 'status' => 'diajukan'));
        foreach ($document_data as $key => $value) {
            $data['status'] = 'diperiksa';
            $this->m_documents->update($value->id, $data);
        }
        redirect('dashboard');
    }

    public function add_deletion($post_data)
    {
        
        $post_data['status'] = 'diajukan';
        
        $insert = $this->m_deletions->add($post_data);
        if ($insert) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di masukan ke database'));
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data gagal di masukan ke database'));
        }
        redirect($this->url.'/deletion');
    }
    public function deletion_upload($id)
    {
        $check_id = $this->m_deletions->getWhere(array('id' => $id))[0];
        
        $config = $this->upload_config($check_id->asset_id);
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', $error['error']));
            //var_dump($error);
            redirect($this->url . '/deletion_image/'.$id);
        } else {
            
            $post_data['image'] = $this->upload->data('file_name');
            $insert = $this->m_deletions->update($id,$post_data);
            if ($insert) {
                $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di update ke database'));
            } else {
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data gagal di masukan ke database'));
            }
            redirect($this->url . '/deletion');
        }

        
    }

    public function deletion_delete($id = null)
    {
        $this->load->model('m_status');
        if ($id != null) {
            $where_id['id'] = $id;           
            if ($this->m_deletions->delete($where_id)) {
                $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di hapus'));
            } else {
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data tidak ditemukan'));
            }
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Anda perlu memilih data yang akan di hapus'));
        }
        redirect($this->url . '/deletion');
    }

    public function upload_config($file_name){
        $config['upload_path']          = './uploads/dokumentasi';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 5000;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $config['overwrite']           = true;
        $config['file_name'] = $file_name;

       return $config;
    }

    public function document()
    {
        $agency_id = $this->session->agency_id;

        //breadcrumbs config
        $this->breadcrumbs->push('Asset', '/asset');
        $this->breadcrumbs->push('Pemusnahan', '/asset/deletion');
        $this->breadcrumbs->push('Upload Dokumen', '/upload_document');
        $this->breadcrumbs->unshift('Admin', '/');


        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Pemusnahan</strong> Aset';
        $data['page_content'] = 'page/asset/document_upload';
        $data['page_current'] = 'page/asset';

        //form props
        $data['form_title'] = "<strong>Upload</strong> Dokumen";
        $data['form_action'] = site_url($this->url . '/document_upload/'.$agency_id);

        $data['page_url'] = site_url($this->url);
        $this->load->view('index', $data);
    }

    public function document_upload($id)
    {

        $agency_data = $this->m_agencies->getWhere(array('id'=>$id))[0];
        $date = date('Y-m-d');
        $file_name = $date. ' SCAN DOCUMENT PENGAJUAN PEMUSNAHAN - '. strtoupper($agency_data->name);

        $config['upload_path']          = './uploads/document';
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 5000;       
        $config['overwrite']           = true;
        $config['file_name'] = $file_name;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', $error['error']));
            //var_dump($error);
            redirect($this->url . '/document_upload/' . $id);
        } else {    
            
            $post_data['name'] = $this->upload->data('file_name');
            $post_data['status'] = 'diajukan';
            $post_data['agency_id'] = $id;
            $insert = $this->m_documents->add($post_data);
            if ($insert) {
                $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di update ke database'));
            } else {
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data gagal di masukan ke database'));
            }
            redirect($this->url . '/deletion');
        }
    }

    public function edit($id)
    {
        //checkk if id is exist
        if ($id == null) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Anda perlu memilih data yang akan di edit'));
            redirect($this->url);
        }

        //breadcrumbs config
        $this->breadcrumbs->push('Asset', '/asset');
        $this->breadcrumbs->push('Edit', '/edit');
        $this->breadcrumbs->unshift('Admin', '/');

        //page props
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Edit</strong> Asset';
        $data['page_content'] = 'page/asset/edit';
        $data['page_current'] = 'page/asset';

        //form props
        $data['form_title'] = "<strong>Edit</strong> Asset";
        $data['form_action'] = site_url($this->url . '/edit/'.$id);
        $data['edit'] = true;

        //select option
        $this->load->model('m_agencies');
        $agency_data = $this->m_agencies->fetch(array('select' => array('id', 'name')));
        $data['agency_select'] = $agency_data;

        //get current data
        $current_data = $this->m_assets->getWhere(array('id'=>$id));
        if(count($current_data)==0){
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data yang akan diedit tidak ditemukan di database'));
            redirect($this->url);
        }else{
            $data['form_value'] = (array) $current_data[0];
        }

        if ($_POST) {
            $this->form_validation_rules();
            if ($this->form_validation->run() == FALSE) {
                $data['form_value'] = $this->input->post();
                $data['validation_error'] =  $this->alert->set_alert('warning', validation_errors());
            } else {
                $post_data = $this->input->post();
                $this->update($id, $post_data);
            }
        }

        $data['page_url'] = site_url($this->url);
        $this->load->view('index',$data);
    }

    public function update($id, $post_data)
    {
        $update = $this->m_assets->update($id, $post_data);
        if ($update) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di update ke database'));
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data gagal di update ke database'));
        }
        redirect($this->url);
    }

    public function delete($id=null)
    {
        $this->load->model('m_status');
        if($id!=null){
            $where_id['id'] = $id;
            if(!$this->m_status->delete(array('asset_id'=>$id))) $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Gagal menghapus status asset'));
            if($this->m_assets->delete($where_id)){
                $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di hapus'));
            }else{
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data tidak ditemukan'));
            }
        }else{
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Anda perlu memilih data yang akan di hapus'));
        }
        redirect($this->url);    
    }

    public function form_validation_rules()
    {

        $this->form_validation->set_rules('asset_code', 'Kode Aset', 'required');
        $this->form_validation->set_rules('type', 'Jenis Aset', 'required');
        $this->form_validation->set_rules('agency_id', 'OPD', 'required|callback_agency_check');
    }

    public function form_status_validation_rules()
    {

        $this->form_validation->set_rules('asset_id', 'Aset', 'required');
        $this->form_validation->set_rules('reason', 'Alasan', 'required');
        
        
    }

    public function agency_check($str)
    {
        if ($str != 0) return TRUE;

        $this->form_validation->set_message('agency_check', 'You must select a {field}');
        return FALSE;
    }


}
    
    /* End of file Assets.php */
