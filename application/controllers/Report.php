<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends MY_Controller
{
    private $url = 'report';
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
        
        
    }
    
    public function index()
    {

        $this->load->library('form_template');
        //breadcrumbs config
        $this->breadcrumbs->push('Report', '/report');
        $this->breadcrumbs->unshift('Admin', '/');

        //data for select
        $this->load->model(array('m_agencies'));
        $data['select_agencies'] = $this->m_agencies->get();

        //if post is send
        if($_POST){
            $fetch_result = $this->fetch_data($this->input->post());
            $table_head = $this->table_head($this->input->post('type'));
            $page_title = $this->report_name($this->input->post());
        }else{
            $fetch_result = false;
            $table_head = false;
            $page_title = '<strong>Report</strong> Management';
        }
        
        

        $data['table_content'] = $fetch_result;
        $data['table_head'] = $table_head ;
        //page properties        
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_title'] = $page_title;
        $data['page_content'] = 'page/report/index';
        $data['page_current'] = 'page/report';
        $data['page_url'] = site_url($this->url);
        $data['view_library'] = array('datatable');

        $this->load->view('index', $data);
    }

    public function fetch_data($post_data){
        $agency_id = $post_data['agency_id'];
        $type = $post_data['type'];
        $filter = $post_data['filter'];

        switch ($type) {
            case 'officer':
                $this->load->model('m_officers');
                $fech['select'] = '*';
                $fech['select_join'] = array('s.status as officer_status');
                $fetch['join'] = array(
                    array(
                        'table' => 'asset_status s',
                        'join' => 'left',
                        'on' => 'officers.id=s.officer_id'

                    )
                );
                $fetch['where'] = ($filter == 'semua') ? array() : array('s.status' => $filter);
                if($agency_id!=0)  array_push($fetch['where'], array('agency_id'=>$agency_id)); 
                $fetch_result = $this->m_officers->fetch($fech);
                break;
            case 'asset':
                $this->load->model('m_assets');
                $fech['select'] = '*';
                $fech['select_join'] =  array('s1.status as asset_status');
                $fetch['join'] = array(
                    array(
                        'table' => 'asset_status s1',
                        'join' => 'left',
                        'on' => 'assets.id=s1.asset_id'
                    ), array(
                        "table" => "asset_status s2",
                        "join" => "left outer",
                        "on" => "(assets.id = s2.asset_id AND 
                            (s1.date_created < s2.date_created OR 
                                (s1.date_created  = s2.date_created AND s1.id < s2.id)))"
                    )
                );
                $fetch['where'] = array('s2.id IS NULL');
                if($filter != 'semua') array_push($fetch['where'], array('s.status' => $filter));
                if ($agency_id != 0)  array_push($fetch['where'], array('agency_id' => $agency_id)); 
                $fetch_result = $this->m_assets->fetch($fech);
                break;
        }
        return $fetch_result;
    }    

    public function table_head($type){
        if($type=='officer'){
            return array('nip'=>'NIP','full_name'=>"Nama",'position'=>"Posisi");
        }else{
            return array('asset_code'=>"Kode Aset", 'type'=>"Jenis", 'brand'=>"Merk");
        }
    }

    public function report_name($post_data){
        $agency_id = $post_data['agency_id'];
        $type = $post_data['type'];
        $filter = $post_data['filter'];
        $name = 'LAPORAN ';
        
        switch ($type) {
            case 'officer':
                $name .= ' ASN ';
                switch ($filter) {
                    case 'menggunakan':
                        $name .= ' YANG MENGGUNAKAN ASET BMD ';
                        break;
                    case 'bebas':
                        $name .= ' YANG BEBAS ASET ';
                        break;
                    default:
                        # code...
                        break;
                }
                break;
            case 'asset':
                $name .= ' ASET BMD ';
                switch ($filter) {
                    case 'kembali':
                        $name .= ' YANG TIDAK DIGUNAKAN ';
                        break;
                    case 'verifikasi':
                        $name .= ' YANG MENUNGU VERIFIKASI ';
                        break;
                    case 'digunakan':
                        $name .= ' YANG DIGUNAKAN ';
                        break;
                    default:
                        # code...
                        break;
                }
                break;
        }
        if ($agency_id != 0) {
            $this->load->model('m_agencies');
            $agency = $this->m_agencies->getWhere(array('id' => $agency_id));
            $code = $agency[0]->code;
            $name .= ' ' . $code . ' ';
        }

        $name .= Date('d-m-Y');

        return $name;
    }

}
    
    /* End of file Reports.php */
    
   
    

?>