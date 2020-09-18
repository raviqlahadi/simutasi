<?php
    
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->check_access();
        $this->load->library('Breadcrumbs');
        $this->load->model(array('m_officers','m_assets','m_status'));
    }
    
    public function index()
    {
        $data['page_content'] = 'page/dashboard/index';

        $data['assets_count'] = $this->count_asset();
        $data['officers_count'] = $this->count_officers();
        $data['assets_bebas_count'] = $this->count_asset_status('kembali');
        $data['assets_dikuasai_count'] = $this->count_asset_status('dikuasai');
       

        //initialize breadcrumbs 
        $this->breadcrumbs->push('Dashboard', '/dashboard');
        $this->breadcrumbs->unshift('Home', '/');            
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->load->view('index', $data);
    }

    public function count_asset(){
        $fetch['select'] = array('*');
        $fetch['where'] = [];
        if($this->session->level!=1) array_push($fetch['where'], array('assets.agency_id'=> $this->session->agency_id));
        $res = $this->m_assets->fetch($fetch,true);
        return $res;
    }
    public function count_officers(){
        $fetch['select'] = array('*');
        $fetch['where'] = [];
        if($this->session->level!=1) array_push($fetch['where'], array('officers.agency_id'=> $this->session->agency_id));
        $res = $this->m_officers->fetch($fetch,true);
        return $res;
    }

    public function count_asset_status($status='kembali'){
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
    
        if($status=='kembali'){
             array_push($fetch['where'], array('s1.status'=> 'kembali'));
             array_push($fetch['where'], array('s1.status'=> 'NULL'));
        }else{
            array_push($fetch['where'], "s1.status != 'kembali'");
        }
        if($this->session->level!=1) array_push($fetch['where'], array('assets.agency_id'=> $this->session->agency_id));
        //var_dump($this->m_assets->fetch($fetch,false,true));
        return $this->m_assets->fetch($fetch,true);
    }

    public function page()
    {
        $data['page_content'] = 'page/dashboard/index';

        //initialize breadcrumbs 
        $this->breadcrumbs->push('Dashboard', '/dashboard');
        $this->breadcrumbs->push('Page', '/page');
        $this->breadcrumbs->unshift('Admin', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->load->view('index', $data);
    }

}
    
    /* End of file Home.php */
