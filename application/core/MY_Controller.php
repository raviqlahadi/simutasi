<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
    public function __construct(){
        parent::__construct();
       
    }

    public function check_access($access=null){
        if (!$this->session->logged_in) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Anda perlu login untuk mengakses halaman ini'));
            redirect('auth');
        }
        
    }

    public function check_privileges($level=array(1)){
        if(!is_array($level)) $level = (array) $level;
        $current_level = $this->session->level;
        $access = false;
        foreach ($level as $key => $value) {
            if($value==$current_level) {
                $access = true;
                break;
            }
        }
        if(!$access) show_404();
    }

   
}





