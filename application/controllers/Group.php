<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Group extends MY_Controller
{
    private $url = 'group';
    public function __construct()
    {
        parent::__construct();
        //check if user loged in
        $this->check_access();

        //check if it is admin root
        $this->check_privileges();

        //load crud page library
        $this->load->library('form_template');
        $this->load->library('table_template');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('breadcrumbs');
        
        $this->load->model('m_groups');
        
        
    }
    
    public function index()
    {


        //page config
        $edit = ($this->input->get('edit') != null ? true : false);
        $limit = $this->input->get('limit');
        $limit_per_page = ($limit != null && $limit != '') ? $limit : 5;
        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
        $start_record = $page * $limit_per_page;        
        
        //table props
        $data['table_head'] = array(
            'name'=>'Nama Grup',
            'description' => 'keterangan'
        );

        $search = ($this->input->get('search') != null ) ? $this->input->get('search') : false ;
        

        if($search){
            $fetch['like'] = array('name'=>array('name','description'), 'key'=>$search);
        }

        $fetch['select'] = array('id','name', 'description');
        $fetch['start'] = $start_record;
        $fetch['limit'] = $limit_per_page;
        $data['table_content'] = $this->m_groups->fetch($fetch);
        $total_records = $this->m_groups->fetch($fetch,true);

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
        $this->breadcrumbs->push('Group', '/group');
        if($edit) $this->breadcrumbs->push('Edit', '/edit');
        $this->breadcrumbs->unshift('Admin', '/');


        //page properties        
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = 'Group Management';
        $data['table_start_number'] = $start_record;
        $data['page_content'] = 'page/group/index';
        $data['page_current'] = 'page/group';
        $data['page_url'] = site_url($this->url);

       
        //form porperties      
        //if edit action clicked
       
        if($edit){
            $id = $this->input->get('id');
            if (isset($id) && $id!=null) {
               $form_value = $this->m_groups->getWhere(array('id'=>$id));
               if(!empty($form_value)){
                    $data['form_value'] = (array) $form_value[0];
                    $data['form_title'] = "<strong>Edit</strong> Group";
                    $data['form_action'] = site_url($this->url.'?edit=true&id='.$id);
               }else{
                    $this->session->set_flashdata('alert', $this->alert->set_alert('warning', 'Data tidak ditemukan di database'));
                    redirect(site_url($this->url));
               }
            } else {
                $this->session->set_flashdata('alert', $this->alert->set_alert('warning', 'Tidak ada data yang dipilih untuk di edit'));
            }

        }else{
            $data['form_title'] = "<strong>Add new</strong> Group";
            $data['form_action'] = site_url($this->url);
        }

        
        
        //if post request send
        if($_POST){
            $this->form_validation_rules($edit);
            if ($this->form_validation->run() == FALSE) {
                $data['form_value'] = $this->input->post();
                $data['validation_error'] =  $this->alert->set_alert('warning', validation_errors());                
            } else {
                $post_data = $this->input->post();
                if($edit){
                    $this->update($id, $post_data);
                }else{
                    $this->add($post_data);
                }
            }
        }

        $this->load->view('index', $data);
    }

    public function form_validation_rules()
    {
        
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[5]|callback_groupname_check');
        $this->form_validation->set_rules('description', 'Description', 'required');
    }

    public function groupname_check($str){
                  
        $data = $this->m_groups->getWhere(array('name'=>$str));
        if(empty($data)){
            return TRUE;
        }
        $edit = ($this->input->get('edit') != null ? true : false);
        if ($edit) {
            $id = $this->input->get('id');
            if ($data[0]->id == $id) {
                return TRUE;
            }
        }

        $this->form_validation->set_message('groupname_check', 'The {field} must be unique');
        return FALSE;  
        
       
    }
    // public function create()
    // {

    // }


    public function add($post_data)
    {

        $insert = $this->m_groups->add($post_data);
        if ($insert) {
            $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di masukan ke database'));
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data gagal di masukan ke database'));
        }
        redirect($this->url);
    }

    // public function edit($id)
    // {   
       
    // }

    public function update($id, $post_data)
    {
        $update = $this->m_groups->update($id, $post_data);
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
            if($this->m_groups->delete($where_id)){
                $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di hapus'));
            }else{
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data tidak ditemukan'));
            }
        }else{
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Anda perlu memilih data yang akan di hapus'));
        }
        redirect($this->url);    
    }



}
    
    /* End of file Groups.php */
    
   
    

?>