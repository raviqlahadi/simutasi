<?php
    
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->library('Breadcrumbs');
        $this->load->model('m_templates');
    }
    

    public function index()
    {
        $data['page_content'] = 'page/setting/index';

        //initialize breadcrumbs 
        $this->breadcrumbs->push('Setting', '/setting');
        $this->breadcrumbs->unshift('Home', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->load->view('index', $data);
    }

    public function template_edit()
    {
        $data['page_content'] = 'page/setting/template_edit';
        $template_name = 'bebas_aset';
        $template_data = $this->check_if_template_exist($template_name);
        //initialize breadcrumbs 
        $this->breadcrumbs->push('Setting', '/setting');
        $this->breadcrumbs->push('Template', '/template_edit');
        $this->breadcrumbs->unshift('Home', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['view_library'] = array('ckeditor');
        $data['template_data'] = $template_data;
        $this->load->view('index', $data);  
    }

    public function template_save(){
        $id = $this->input->post('id');
        $data['template'] = $this->input->post('template');
        
        $update = $this->m_templates->update($id, $data);
        if ($update) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di update ke database'));
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data gagal di masukan ke database'));
        }
        redirect('setting/template_edit');
      
    }

    public function check_if_template_exist($name){
        $template = $this->m_templates->getWhere(array('name' => $name));
        if(count($template) > 0) return $template[0];

        $data['name'] = $name;
        $data['template'] = '';
        
        $add = $this->m_templates->add($data);
        
        if($add) return redirect(site_url('setting/template_edit'));         
    }

}
    
    /* End of file Setting.php */
    

?>