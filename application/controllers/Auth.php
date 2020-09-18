<?php
    
  
  defined('BASEPATH') OR exit('No direct script access allowed');
  
  class Auth extends CI_Controller {
        
    public function __construct()
    {
        
        parent::__construct();
        //Do your magic here
        $this->load->model('m_users');
        $this->load->model('m_groups');
        //uncommend this to add root user

        // $root_user = $this->m_users->getWhere(array('id' => 1));
        // if (count($root_user) == 0) $this->add_root_user();
       
        
    }
        
    public function index()
    {
        if ($this->session->logged_in) {
            redirect('dashboard');
        }
        $this->load->view('auth/index');
    }

    public function check_user()
    {
        $email = $this->input->post('username');
        $password = $this->input->post('password');
       
        $user_data = $this->m_users->getWhere(array('email'=>$email));
        if(!empty($user_data)){
            $user_data = $user_data[0];
            if(password_verify($password, $user_data->password)){
                $new_user = array(
                    'userid' => $user_data->id,
                    'username' => $user_data->username,
                    'level' => $user_data->group_id,
                    'email' => $user_data->email,
                    'agency_id' => $user_data->agency_id,
                    'logged_in' => true
                );
                $this->session->set_userdata($new_user);
                redirect('dashboard');
            }else{
                
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger','Password yang anda masukan salah'));
                redirect('auth');
            }
        }else{
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'User tidak ditemukan'));
            redirect('auth');
        }
        
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');

    }

    private function add_root_user()
    {
        $admin_level = $this->m_groups->getWhere(array('name'=>'admin'));
        if(count($admin_level)==0){
            $group['name'] = 'admin';
            $group['description'] = 'this is admin root';

            if ($this->m_groups->add($group)) {
                echo "<span style='padding-left:10px;'>there is error when running sql command to add group.</span>";
                die();
            } else {
                $group_id = $this->m_groups->add($group);
                
            }
        }else{
            $group_id = $admin_level[0]->id;   
        }
        $password_hash = password_hash('admin1234', PASSWORD_DEFAULT);
        $user = array(
            'username' => 'admin root',
            'email' => 'admin@root',
            'agency_id' => 1,
            'password' => $password_hash,
            'group_id' => $group_id
        );
        $add_user = $this->m_users->add($user);
        if (!$add_user) {
            var_dump($user);
            echo "<span style='padding-left:10px;'>there is error when running sql command when add users.</span>";
            die();
        }
    }
  }
  
  

  /* End of file Auth.php */
    

?>