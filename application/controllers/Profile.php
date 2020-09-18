<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    
class Profile extends CI_Controller {
    
    private $url = 'profile';

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->library('form_template');
        $this->load->library('form_validation');
        $this->load->library('breadcrumbs');
        
        $this->load->model('m_profiles');
        $this->load->model('m_users');
        
    }
    
    public function index($id=null)
    {
        //check if user_profile exist in database, if not, create it first
        $this->check_profile_exist();

        //get user profile data
        if($id==null) $id = $this->session->userid;    
        
        $user_profile = $this->m_profiles->getWhere(array('user_id' => $id))[0];
        $fetch['select'] = array('username','email');
        $fetch['select_join']  = array('g.name as level');
        $fetch['join'] = array(
            array(
            'table' => 'groups g',
            "fk" => "group_id",
            'previx'=>'g',
            'join'=>'left',
            )
            
        );
        $fetch['where'] = array('users.id'=>$id);
        $user_data = $this->m_users->fetch($fetch)[0];
        
        $all_user_data  = (object) array_merge((array) $user_data, (array) $user_profile);;
        //breadcrumbs config
        $this->breadcrumbs->push('Profile', '/profile');
        $this->breadcrumbs->unshift('Admin', '/');

        //page properties        
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['user_profile'] = $all_user_data;
        $data['page_content'] = 'page/profile/index';

        $this->load->view('index', $data);        
    }

    public function create($id=null)
    {
        //check if $id is exist then check if user is exist in database
        if($id==null){
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Anda harus memilih user sebelum menambah profile'));
            redirect('dashboard');
        }
        //$this->check_if_have_access($id);
        $this->check_user_exist($id);
        if($this->check_profile_exist()) redirect(site_url($this->url).'/edit/'.$id);

        //breadcrumbs config
        $this->breadcrumbs->push('Profile', '/profile');
        $this->breadcrumbs->push('Create', '/create');
        $this->breadcrumbs->unshift('Admin', '/');

        //page props
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Add New</strong> Profile';
        $data['page_content'] = 'page/profile/create';
        $data['page_current'] = 'page/profile';

        //form props
        $data['form_title'] = "<strong>Add new</strong> Profile";
        $data['form_action'] = site_url($this->url . '/create/'.$id);

        //radio option
        $gender_data = array(
            array(
                'value'=>'laki-laki',
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
                $post_data['user_id'] = $id;
                $this->add($post_data);
            }
        }

        $data['page_url'] = site_url($this->url);
        $this->load->view('index', $data);
    }


    public function add($post_data)
    {
        if (array_key_exists('password_confirm', $post_data)) unset($post_data['password_confirm']);
        $insert = $this->m_profiles->add($post_data);
        if ($insert) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di masukan ke database'));
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data gagal di masukan ke database'));
        }
        redirect($this->url);
    }

    public function edit($id)
    {
        //check if $id is exist then check if user is exist in database
        if ($id == null) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Anda harus memilih user sebelum menambah profile'));
            redirect('dashboard');
        }
        $this->check_user_exist($id);
        $this->check_if_have_access($id);
       
        //breadcrumbs config
        $this->breadcrumbs->push('Profile', '/profile');
        $this->breadcrumbs->push('Edit', '/edit');
        $this->breadcrumbs->unshift('Admin', '/');

        //page props
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = '<strong>Edit</strong> Profile';
        $data['page_content'] = 'page/profile/edit';
        $data['page_current'] = 'page/profile';

        //form props
        $data['form_title'] = "<strong>Edit</strong> Profile";
        $data['form_action'] = site_url($this->url . '/edit/' . $id);

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

        //get current data from database
        $form_value = $this->m_profiles->getWhere(array('id'=>$id))[0];
        $data['form_value'] = (array) $form_value;
        if ($_POST) {
            $this->form_validation_rules();
            if ($this->form_validation->run() == FALSE) {
                $data['form_value'] = $this->input->post();
                $data['validation_error'] =  $this->alert->set_alert('warning', validation_errors());
            } else {
                $post_data = $this->input->post();
                $post_data['user_id'] = $id;
                $this->update($id,$post_data);
            }
        }

        $data['page_url'] = site_url($this->url);
        $this->load->view('index', $data);
    }

    public function update($id, $post_data)
    {
        $update = $this->m_profiles->update($id, $post_data);
        if ($update) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di update ke database'));
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data gagal di update ke database'));
        }
        redirect($this->url);
    }

    public function delete($id = null)
    {
        if ($id != null) {
            $where_id['id'] = $id;
            if ($this->m_profiles->delete($where_id)) {
                $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di hapus'));
            } else {
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data tidak ditemukan'));
            }
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Anda perlu memilih data yang akan di hapus'));
        }
        redirect($this->url);
    }

    private function form_validation_rules()
    {

        $this->form_validation->set_rules('phone', 'Telepon', 'required');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('position', 'Jabatan', 'required');
    }


    private function check_profile_exist(){
        $user_id = $this->session->userid;
        $user_profile = $this->m_profiles->getWhere(array('user_id' => $user_id));
        if(count($user_profile)==0){
            $this->session->set_flashdata('alert', $this->alert->set_alert('warning', 'Anda perlu mengisi profile data sebelum melanjutkan'));
            return redirect(site_url('profile/create/' . $user_id));
        }
        return true;
    }

    private function check_if_have_access($id){
        $role = $this->session->level;
        if($role!=1){            
           if($id!=$this->session->userid){
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Anda tidak memiliki akses'));
                redirect('dashboard');
            }
        }

        return true;

    }
    private function check_user_exist($id){
        $this->load->model('m_users');
        $user_data = $this->m_users->getWhere(array('id'=>$id));
        if(count($user_data)==0){
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'User tidak ditemukan di database'));
            if($this->session->level==1){
                redirect(site_url('user'));
            }else{
                redirect(site_url('profile'));
            }
        }
        
    }

}

/* End of file Profile.php */
    

?>