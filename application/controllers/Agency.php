<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agency extends MY_Controller
{
    private $url = 'agency';
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->check_access();

        //check if have previlages to access 
        $this->check_privileges();

        $this->load->library('form_template');
        $this->load->library('table_template');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('breadcrumbs');
        
        $this->load->model('m_agencies');
           
        
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
            'name' => 'Nama OPD',
            'code' => 'Kode',
            'ministry' => 'Kementrian',
            
        );

        $search = ($this->input->get('search') != null ) ? $this->input->get('search') : false ;
        

        if($search){
            $fetch['like'] = array('name'=>array('name','code'), 'key'=>$search);
        }

        $fetch['select'] = array('id', 'code', 'name', 'ministry', 'phone', 'fax', 'email', 'website', 'address');
        $fetch['start'] = $start_record;
        $fetch['limit'] = $limit_per_page;
        $data['table_content'] = $this->m_agencies->fetch($fetch);
        $total_records = $this->m_agencies->fetch($fetch,true);

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
        $this->breadcrumbs->push('Agency', '/agency');
        $this->breadcrumbs->unshift('Admin', '/');


        //page properties        
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Agency</strong> Management';
        $data['table_start_number'] = $start_record;
        $data['page_content'] = 'page/agency/index';
        $data['page_current'] = 'page/agency';
        $data['page_url'] = site_url($this->url);

        $this->load->view('index', $data);
    }

    
    public function create()
    {
        
        //breadcrumbs config
        $this->breadcrumbs->push('Agency', '/agency');
        $this->breadcrumbs->push('Create', '/create');
        $this->breadcrumbs->unshift('Admin', '/');

        //page props
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Add New</strong> Agency';
        $data['page_content'] = 'page/agency/create';
        $data['page_current'] = 'page/agency';

        //form props
        $data['form_title'] = "<strong>Add new</strong> Agency";
        $data['form_action'] = site_url($this->url.'/create');

        $this->load->model('m_officers');
        $temp_officers = $this->m_officers->fetch(array('select' => array('id', 'full_name')));
        $officers = array();
        foreach ($temp_officers as $key => $value) {
            array_push($officers, array(
                'id' => $value->id,
                'name' => $value->full_name
            ));
        }
        $data['officers_select'] = $officers;


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
        if(array_key_exists('password_confirm', $post_data)) unset($post_data['password_confirm']);
        $insert = $this->m_agencies->add($post_data);
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
        $this->breadcrumbs->push('Agency', '/agency');
        $this->breadcrumbs->push('Edit', '/edit');
        $this->breadcrumbs->unshift('Admin', '/');

        //page props
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Edit</strong> Agency';
        $data['page_content'] = 'page/agency/edit';
        $data['page_current'] = 'page/agency';

        //form props
        $data['form_title'] = "<strong>Edit</strong> Agency";
        $data['form_action'] = site_url($this->url . '/edit/'.$id);
        $data['edit'] = true;

        $this->load->model('m_officers');
        $temp_officers = $this->m_officers->fetch(array('select' => array('id', 'full_name')));
        $officers = array();
        foreach ($temp_officers as $key => $value) {
            array_push($officers, array(
                'id' => $value->id,
                'name' => $value->full_name
            ));
        }
        $data['officers_select'] = $officers;

        //get current data
        $current_data = $this->m_agencies->getWhere(array('id'=>$id));
        if(count($current_data)==0){
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data yang akan diedit tidak ditemukan di database'));
            redirect($this->url);
        }else{
            $data['form_value'] = (array) $current_data[0];
        }

        if ($_POST) {
            $this->form_validation_rules(TRUE);
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
        $update = $this->m_agencies->update($id, $post_data);
        if ($update) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di update ke database'));
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data gagal di update ke database'));
        }
        redirect($this->url);
    }

    public function delete($id=null)
    {
        if($id!=null){
            $where_id['id'] = $id;
            if($this->m_agencies->delete($where_id)){
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
        $this->form_validation->set_rules('code', 'Kode OPD', 'required|min_length[5]|callback_code_check');
        $this->form_validation->set_rules('name', 'Nama OPD', 'required');
        $this->form_validation->set_rules('hod_id', 'Kepala Dinas', 'required');
        $this->form_validation->set_rules('ao_id', 'Pejabat Aset', 'required');
        $this->form_validation->set_rules('email', 'Email', 'min_length[5]|callback_email_check');
       
    }

    public function email_check($str)
    {

        $data = $this->m_agencies->getWhere(array('email' => $str));
        if (empty($data))  return TRUE;
        if ($data[0]->email=='')  return TRUE;

        $edit = ($this->uri->segment(2) != null &&  $this->uri->segment(2) == 'edit' ? true : false);
        if ($edit) {
            $id = $this->uri->segment(3);
            if ($data[0]->id == $id) {
                return TRUE;
            }
        }

        $this->form_validation->set_message('email_check', 'The {field} already taken. please use another email');
        return FALSE;
    }

    public function code_check($str)
    {

        $data = $this->m_agencies->getWhere(array('code' => $str));
        if (empty($data)) {
            return TRUE;
        }
        $edit = ($this->uri->segment(2) != null &&  $this->uri->segment(2) == 'edit' ? true : false);
        if ($edit) {
            $id = $this->uri->segment(3);
            if ($data[0]->id == $id) {
                return TRUE;
            }
        }

        $this->form_validation->set_message('code_check', 'The {field} already taken. please use another email');
        return FALSE;
    }



}
    
    /* End of file Agencys.php */
    
   
    

?>