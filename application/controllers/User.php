<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
    private $url = 'user';
    public function __construct()
    {
        parent::__construct();
        //check if user loged in
        $this->check_access();

        //check if it is admin root
        $this->check_privileges();

        $this->load->library('form_template');
        $this->load->library('table_template');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('breadcrumbs');
        
        $this->load->model('m_users');
        
        
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
            'username' => 'Nama User',
            'email' => 'Email',
            'level' => 'Level User'
        );

        $search = ($this->input->get('search') != null ) ? $this->input->get('search') : false ;
        

        if($search){
            $fetch['like'] = array('name'=>array('username' => '','email'), 'key'=>$search);
        }

        $fetch['select'] = array('id','username', 'email');
        $fetch['select_join'] = array('g.name as level');
        $fetch['join'] = array(
            array(
                "table"=>"groups g",
                "fk"=>"group_id",
                "join"=>"left",
                "previx"=>"g"
        ));
        $fetch['start'] = $start_record;
        $fetch['limit'] = $limit_per_page;
        $data['table_content'] = $this->m_users->fetch($fetch);
        $total_records = $this->m_users->fetch($fetch,true);

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
        $this->breadcrumbs->push('User', '/user');
        $this->breadcrumbs->unshift('Admin', '/');


        //page properties        
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>User</strong> Management';
        $data['table_start_number'] = $start_record;
        $data['page_content'] = 'page/user/index';
        $data['page_current'] = 'page/user';
        $data['page_url'] = site_url($this->url);

        $this->load->view('index', $data);
    }

    
    public function create()
    {
        
        //breadcrumbs config
        $this->breadcrumbs->push('User', '/user');
        $this->breadcrumbs->push('Create', '/create');
        $this->breadcrumbs->unshift('Admin', '/');

        //page props
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Add New</strong> User';
        $data['page_content'] = 'page/user/create';
        $data['page_current'] = 'page/user';

        //form props
        $data['form_title'] = "<strong>Add new</strong> User";
        $data['form_action'] = site_url($this->url.'/create');

        //select option
        $this->load->model('m_groups');
        $group_data = $this->m_groups->fetch(array('select'=>array('id','name')));
        $data['group_select'] = $group_data;

        //select option
        $this->load->model('m_agencies');
        $agencies_data = $this->m_agencies->fetch(array('select' => array('id', 'name')));
        $data['agencies_select'] = $agencies_data;


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
        $post_data['password'] = password_hash($post_data['password'], PASSWORD_DEFAULT);
        $insert = $this->m_users->add($post_data);
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
        $this->breadcrumbs->push('User', '/user');
        $this->breadcrumbs->push('Edit', '/edit');
        $this->breadcrumbs->unshift('Admin', '/');

        //page props
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Edit</strong> User';
        $data['page_content'] = 'page/user/edit';
        $data['page_current'] = 'page/user';

        //form props
        $data['form_title'] = "<strong>Edit</strong> User";
        $data['form_action'] = site_url($this->url . '/edit/'.$id);
        $data['edit'] = true;

        //select option
        $this->load->model('m_groups');
        $group_data = $this->m_groups->fetch(array('select' => array('id', 'name')));
        $data['group_select'] = $group_data;

        //select option
        $this->load->model('m_agencies');
        $agencies_data = $this->m_agencies->fetch(array('select' => array('id', 'name')));
        $data['agencies_select'] = $agencies_data;


        //get current data
        $current_data = $this->m_users->getWhere(array('id'=>$id));
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

    public function password($id)
    {
        //checkk if id is exist
        if ($id == null) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Anda perlu memilih data yang akan di edit'));
            redirect($this->url);
        }

        //breadcrumbs config
        $this->breadcrumbs->push('User', '/user');
        $this->breadcrumbs->push('Edit Password', '/password');
        $this->breadcrumbs->unshift('Admin', '/');

        //page props
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Edit</strong> Password';
        $data['page_content'] = 'page/user/password';
        $data['page_current'] = 'page/user';

        //form props
        $data['form_title'] = "<strong>Edit</strong> Password";
        $data['form_action'] = site_url($this->url . '/password/' . $id);
        $data['edit'] = true;


        //get current data
        $current_data = $this->m_users->getWhere(array('id' => $id));
        if (count($current_data) == 0) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data yang akan diedit tidak ditemukan di database'));
            redirect($this->url);
        }

        if ($_POST) {
            $this->password_validation_rules(TRUE);
            if ($this->form_validation->run() == FALSE) {
                $data['form_value'] = $this->input->post();
                $data['validation_error'] =  $this->alert->set_alert('warning', validation_errors());
            } else {
                $post_data['password'] = password_hash($this->input->post('password'),PASSWORD_DEFAULT);
                $this->update($id, $post_data);
            }
        }

        $data['page_url'] = site_url($this->url);
        $this->load->view('index', $data);
    }

    public function update($id, $post_data)
    {
        if (array_key_exists('password_confirm', $post_data)) unset($post_data['password_confirm']);
        $update = $this->m_users->update($id, $post_data);
       
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
            if($this->m_users->delete($where_id)){
                $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di hapus'));
            }else{
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data tidak ditemukan'));
            }
        }else{
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Anda perlu memilih data yang akan di hapus'));
        }
        redirect($this->url);    
    }

    private function form_validation_rules($edit=false)
    {

        $this->form_validation->set_rules('username', 'User Name', 'required|min_length[5]');
        $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|callback_email_check');
        $this->form_validation->set_rules('group_id', 'User Level', 'required|callback_select_check');
        $this->form_validation->set_rules('agency_id', 'OPD', 'required|callback_select_check');
        if(!$edit){
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
            $this->form_validation->set_rules('password_confirm', 'Password Confirm', 'required|min_length[5]|matches[password]');
        }
    }

    public function password_validation_rules(){
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirm', 'required|min_length[5]|matches[password]');
    }


    public function email_check($str)
    {

        $data = $this->m_users->getWhere(array('email' => $str));
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

        $this->form_validation->set_message('email_check', 'The {field} already taken. please use another email');
        return FALSE;
    }

    public function select_check($str)
    {
        if($str!=0) return TRUE;

        $this->form_validation->set_message('select_check', 'You must select a {field}');
        return FALSE;
    }


}
    
    /* End of file Users.php */
    
   
    

?>