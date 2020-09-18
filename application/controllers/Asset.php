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
            'agency_name' => 'OPD'
        );

        $search = ($this->input->get('search') != null ) ? $this->input->get('search') : false ;        

        if($search){
            $fetch['like'] = array('name'=>array('asset_code','type','brand'), 'key'=>$search);
        }

        $fetch['select'] = array('id','asset_code', 'type', 'brand');
        $fetch['select_join'] = array(
            'a.name as agency_name',
            's1.status as asset_status',
            'o.full_name as officer_name'
        );
        $fetch['join'] = array(
            array(
                "table" => "agencies a",
                "join" => "left",
                "on" => "a.id = assets.agency_id"
            ),
            array(
                "table" => "asset_status s1",
                "join" => "left",
                "on" => "s1.asset_id = assets.id"
            ),
            array(
                "table" => "asset_status s2",
                "join" => "left outer",
                "on" => "(assets.id = s2.asset_id AND 
                            (s1.date_created < s2.date_created OR 
                                (s1.date_created  = s2.date_created AND s1.id < s2.id)))"
            ),
            array(
                "table" =>"officers o",
                "join" => "left",
                "on" => "o.id = s1.officer_id"
            )

        );
        $fetch['where'] = array('s2.id IS NULL');
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

    public function status($id)
    {

        //checkk if id is exist
        if ($id == null) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Anda perlu memilih data yang akan di edit'));
            redirect($this->url);
        }else{
            //get current data
            $current_data = $this->m_assets->getWhere(array('id' => $id));
            if (count($current_data) == 0) {
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data yang akan diedit tidak ditemukan di database'));
                redirect($this->url);
            }
        }

        //breadcrumbs config
        $this->breadcrumbs->push('Asset', '/asset');
        $this->breadcrumbs->push('Status', '/status');
        $this->breadcrumbs->unshift('Admin', '/');

        //page props
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Update Status</strong> Aset';
        $data['page_content'] = 'page/asset/status';
        $data['page_current'] = 'page/asset';

        //form props
        $data['form_title'] = "<strong>Update Status</strong> Aset";
        $data['form_action'] = site_url($this->url . '/status/'.$id);

        //select option
        $this->load->model('m_officers');
        $temp_officers = $this->m_officers->fetch(array('select' => array('id', 'full_name')));
        $officers = array();
        foreach ($temp_officers as $key => $value) {
           array_push($officers, array(
               'id'=>$value->id,
               'name'=>$value->full_name
           ));
        }
        $data['officers_select'] = $officers;
        $admin_root =
        array(
            array(
                'id' => 'digunakan',
                'name' => 'Digunakan'
            ),
            array(
                'id' => 'verifikasi',
                'name' => 'Verifikasi'
            ),
            array(
                'id' => 'kembali',
                'name' => 'Kembali'
            )
        );
        $admin_opd =
        array(
            array(
                'id' => 'digunakan',
                'name' => 'Digunakan'
            ),
            array(
                'id' => 'verifikasi',
                'name' => 'Kembali'
            )
        );
        $data['status_select'] = ($this->session->level==1) ? $admin_root : $admin_opd;

        //check if prev status is exist 
        $this->load->model('m_status');
        $prev_status = $this->m_status->fetch(array(
            'where' => ["asset_id"=>$id],
            'order' => ['field'=>'date_created','type'=>'ASC'],
            'limit' => 1));

        
        if(count($prev_status) > 0) $data['form_value'] = (array) $prev_status[0];

        if ($_POST) {
            $this->form_status_validation_rules();
            if ($this->form_validation->run() == FALSE) {
                $data['form_value'] = $this->input->post();
                $data['asset_id'] = $id;
                $data['validation_error'] =  $this->alert->set_alert('warning', validation_errors());
            } else {
                $post_data = $this->input->post();
                $post_data['asset_id'] = $id;
                $this->add_status($post_data);
            }
        }

        $data['page_url'] = site_url($this->url);
        $this->load->view('index', $data);
    }


    public function add_status($post_data)
    {
        $this->load->model('m_status');
        if($post_data['officer_id']==0) unset($post_data['officer_id']);
        $insert = $this->m_status->add($post_data);
        if ($insert) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di masukan ke database'));
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data gagal di masukan ke database'));
        }
        redirect($this->url);
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

        $this->form_validation->set_rules('status', 'Status Aset', 'required');
        
    }

    public function agency_check($str)
    {
        if ($str != 0) return TRUE;

        $this->form_validation->set_message('agency_check', 'You must select a {field}');
        return FALSE;
    }


}
    
    /* End of file Assets.php */
