<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Officer extends MY_Controller
{
    private $url = 'officer';
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->check_access();

        $this->load->library('table_template');
        $this->load->library('form_template');
        $this->load->library('form_validation');
        $this->load->library('breadcrumbs');
        $this->load->library('pagination');
        
        
        $this->load->model('m_officers');
        
        
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
            'nip'=>'NIP',
            'full_name'=>'Nama',
            'position'=>'Jabatan',
            'agency_name'=>'Instansi');
        
        $search = ($this->input->get('search') != null ) ? $this->input->get('search') : false ;
        

        if($search){
            $fetch['like'] = array('name'=>array('nip','full_name'), 'key'=>$search);
        }
        
        // SELECT o.*, (SELECT s.status FROM asset_status s WHERE s.officer_id=o.id 
        // ORDER BY s.date_created DESC LIMIT 1) as statusBebas FROM officers o

        $fetch['select'] = array('id','nip', 'full_name','position');
        $fetch['select_join'] = array('a.name as agency_name');
        $fetch['join'] = array(
            array(
                "table"=>"agencies a",
                "on" => "officers.agency_id = a.id",
                "join"=>"left",
                
        ));
        $fetch['start'] = $start_record;
        $fetch['limit'] = $limit_per_page;
        $fetch['where'] = [];
        if ($this->session->level != 1) array_push($fetch['where'], array('officers.agency_id' => $this->session->agency_id));
        $data['table_content'] = $this->m_officers->fetch($fetch);
        $total_records = $this->m_officers->fetch($fetch,true);

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
        $this->breadcrumbs->push('Officer', '/officer');
        $this->breadcrumbs->unshift('Admin', '/');


        //page properties        
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Officer</strong> Management';
        $data['table_start_number'] = $start_record;
        $data['page_content'] = 'page/officer/index';
        $data['page_current'] = 'page/officer';
        $data['page_url'] = site_url($this->url);

        $this->load->view('index', $data);
    }

    
    public function create()
    {
        
        //breadcrumbs config
        $this->breadcrumbs->push('Officer', '/officer');
        $this->breadcrumbs->push('Create', '/create');
        $this->breadcrumbs->unshift('Admin', '/');

        //page props
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Add New</strong> Officer';
        $data['page_content'] = 'page/officer/create';
        $data['page_current'] = 'page/officer';

        //form props
        $data['form_title'] = "<strong>Add new</strong> Officer";
        $data['form_action'] = site_url($this->url.'/create');

        //select option
        $this->load->model('m_agencies');
        //if admin opd
        $is_admin_opd = ($this->session->level != 1) ? true : false;
        if ($is_admin_opd) {
            $data['form_value']['agency_id'] = $this->session->agency_id;
            $data['agency_readonly'] = true;
            $fetch['where'] = array('id'=> $this->session->agency_id);
        }
        $fetch['select'] = array('id', 'name');
        $agency_data = $this->m_agencies->fetch($fetch);
        $data['agency_select'] = $agency_data;

        //select religion
        $religion_select = array(
            array('id' => 'islam','name' => 'Islam'),
            array('id' => 'protestan', 'name' => 'Protestan'),
            array('id' => 'katolik', 'name' => 'Katolik'),
            array('id' => 'hindu', 'name' => 'Hindu'),
            array('id' => 'budha', 'name' => 'Budha'), 
        );
        $data['religion_select'] = $religion_select;
        //radio option
        $gender_data = array(
            array(
                'value' => 'laki-laki',
                'label' => 'Laki-Laki'
            ), array(
                'value' => 'perempuan',
                'label' => 'Perempuan'
            ),
        );
        $data['gender_option'] = $gender_data;
        


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
        $insert = $this->m_officers->add($post_data);
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
        $this->breadcrumbs->push('Officer', '/officer');
        $this->breadcrumbs->push('Edit', '/edit');
        $this->breadcrumbs->unshift('Admin', '/');

        //page props
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Edit</strong> Officer';
        $data['page_content'] = 'page/officer/edit';
        $data['page_current'] = 'page/officer';

        //form props
        $data['form_title'] = "<strong>Edit</strong> Officer";
        $data['form_action'] = site_url($this->url . '/edit/'.$id);
        $data['edit'] = true;

        //select option
        $this->load->model('m_agencies');
        $agency_data = $this->m_agencies->fetch(array('select' => array('id', 'name')));
        $data['agency_select'] = $agency_data;

        //select religion
        $religion_select = array(
            array('id' => 'islam', 'name' => 'Islam'),
            array('id' => 'protestan', 'name' => 'Protestan'),
            array('id' => 'katolik', 'name' => 'Katolik'),
            array('id' => 'hindu', 'name' => 'Hindu'),
            array('id' => 'budha', 'name' => 'Budha'),
        );
        $data['religion_select'] = $religion_select;
        //radio option
        $gender_data = array(
            array(
                'value' => 'laki-laki',
                'label' => 'Laki-Laki'
            ), array(
                'value' => 'perempuan',
                'label' => 'Perempuan'
            ),
        );
        $data['gender_option'] = $gender_data;

        //get current data
        $current_data = $this->m_officers->getWhere(array('id'=>$id));
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
        $update = $this->m_officers->update($id, $post_data);
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
            if($this->m_officers->delete($where_id)){
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

        $this->form_validation->set_rules('nip', 'NIP', 'required|min_length[5]');
        $this->form_validation->set_rules('full_name', 'Nama Asn', 'required|min_length[3]');
        $this->form_validation->set_rules('agency_id', 'OPD', 'required|callback_agency_check');
    
        
    }

    public function agency_check($str)
    {
        if($str!=0) return TRUE;

        $this->form_validation->set_message('agency_check', 'You must select a {field}');
        return FALSE;
    }


}
    
    /* End of file Officers.php */
