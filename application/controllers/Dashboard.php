<?php
    
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    private $url = 'dashboard';
    
    public function __construct()
    {
        parent::__construct();
        $this->check_access();
        $this->load->library('Breadcrumbs');
        $this->load->model(array('m_officers','m_assets','m_status'));
        $this->load->model('m_documents');
        $this->load->model('m_deletions');
        $this->load->model('m_agencies');
        $this->load->library('form_template');
    }
    
    public function index()
    {
        $data['page_content'] = 'page/dashboard/index';
        
        $agency_id = $this->session->agency_id;

        if($this->session->level==1){
            $data['table_head'] = array(
                'name' => 'Nama OPD',
                'number_of_assets' => 'Jumlah Aset Yang Diajukan',
            );
            $data['table_content'] = $this->admin_content();
            
        }else{
            $data['table_head'] = array(
                'asset_code' => 'Kode Aset',
                'type' => 'Jenis',
                'brand' => "Merk",
                'police_number' => "Nomor Polisi",
            );
            $data['table_content'] = $this->opd_content($agency_id);
        }
        

        //get document
        $document = $this->m_documents->getWhere(array('agency_id' => $agency_id, 'status' => 'diajukan'));
        if (count($document) > 0) {
            $data['document'] = $document[0];
        }

        //initialize breadcrumbs 
        $this->breadcrumbs->push('Dashboard', '/dashboard');
        $this->breadcrumbs->unshift('Home', '/');            
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->load->view('index', $data);
    }

    public function admin_content(){
 
        //asset remove list
        $fetch['select'] = array('id','name');
        $fetch['select_join'] = array('count(d.agency_id) as number_of_assets ');
        $fetch['join'] = array(
            array(
                "table" => "asset_deletions d",
                "join" => "join",
                "on" => "d.agency_id = agencies.id"
            ),
        );
        $fetch['where'] = [];
        array_push($fetch['where'], array('d.status' => 'diajukan'));
        $fetch['group'] = array('field'=>'d.agency_id');
        return $this->m_agencies->fetch($fetch);

    }

    public function opd_content($agency_id){

        
        //asset remove list
        $fetch['select'] = array('*');
        $fetch['select_join'] = array('d.id as status_id, d.reason, d.status, d.image, d.depreciation');
        $fetch['join'] = array(
            array(
                "table" => "asset_deletions d",
                "join" => "join",
                "on" => "d.asset_id = assets.id"
            ),
        );
        $fetch['where'] = [];
       
        array_push($fetch['where'], array('assets.agency_id' => $agency_id));
        array_push($fetch['where'], array('d.status' => 'diajukan'));
        return $this->m_assets->fetch($fetch);
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


    public function import_csv()
    {


        $this->breadcrumbs->push('Import', '/dashboard/import_kib');
        $this->breadcrumbs->unshift('Home', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_content'] = 'page/dashboard/import_csv';
        $data['page_title'] = '<strong>Pemusnahan</strong> Aset';
        $data['page_current'] = 'page/dashboard';

        //form props
        $data['form_title'] = "<strong>Pemusnahan</strong> Aset";
        $data['form_action'] = site_url('dashboard/import_insert');

        $data['page_url'] = site_url($this->url);
        $this->load->view('index', $data);
    }


    function import_insert()
    {

      
        if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
            //echo "<h1>" . "File ". $_FILES['filename']['name'] ." Berhasil di Upload" . "</h1>";
            //echo "<h2>Menampilkan Hasil Upload:</h2>";
            //readfile($_FILES['filename']['tmp_name']);
            //$filename= $_FILES['filename']['name'];
        }
        //Import uploaded file to Database, Letakan dibawah sini..
        $handle = fopen($_FILES['userfile']['tmp_name'], "r"); //Membuka file dan membacanya
        $no = 0;
        $this->db->trans_begin();
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            if ($data[0] != "" && $data[0] != null) {
                foreach ($data as $key => $value) {
                    $data[$key] = addslashes($value);
                }
                $data[0] = str_replace('n','',$data[0]);
                $import = $this->db->query("INSERT INTO
           officers(
             nip,
             full_name,
             position,
             agency_id
			 )
              VALUES ('$data[0]','$data[1]','$data[2]','$data[3]')");

                $no++;
            } else {
                $status['message'] = ' Jumlah Kolom tidak sesuai';
                $status['type'] = 'danger';
                $status['color'] = 'red';
                var_dump($status);

                fclose($handle); //Menutup CSV file
                //redirect('kibassettetap/aset/import');
            }
        }
        $this->db->trans_complete();
        fclose($handle); //Menutup CSV file
        echo "done ".$no." masuk ke db";
    }


}   
    
    /* End of file Home.php */
    // public function import_kib($start=0)
    // {
        
    
    //     $this->breadcrumbs->push('Import', '/dashboard/import_kib');
    //     $this->breadcrumbs->unshift('Home', '/');
    //     $data['breadcrumbs'] = $this->breadcrumbs->show();
    //     $data['page_content'] = 'page/dashboard/import';


    //     $this->load->model('m_kib');

    //     $fetch['select'] = array('*');
    //     $count = $this->m_kib->fetch($fetch,true);
    //     $fetch['start'] = $start;
    //     $fetch['limit'] = 500;
    //     $data_import = $this->m_kib->fetch($fetch);
        

       
    //     $data['count'] = $count;
    //     if($start+500>$count){
    //         $data['data_import'] = $data_import;
    //         foreach ($data_import as $key => $value) {
    //             $post_data['asset_code'] = $value->kode_barang;
    //             $post_data['type'] = $value->jenis_barang;
    //             $post_data['register_number'] = $value->nomor_registrasi;
    //             $post_data['brand'] = $value->merk;
    //             $post_data['year_purchased'] = $value->tahun_pembelian;
    //             $post_data['color'] = $value->warna;
    //             $post_data['size'] = $value->ukuran;
    //             $post_data['material'] = $value->bahan;
    //             $post_data['factory_number'] = $value->nomor_pabrik;
    //             $post_data['chassis_number'] = $value->nomor_rangka;
    //             $post_data['machine_number'] = $value->nomor_mesin;
    //             $post_data['police_number'] = $value->nomor_polisi;
    //             $post_data['bpkb_number'] = $value->nomor_bpkb;
    //             $post_data['price'] = $value->harga;
    //             $post_data['agency_id'] = $this->get_agency_id($value->id_skpd);
    //             $post_data['origin'] = $value->asal_usul;
    //             $post_data['code_number'] = $value->no_kode;
    //             $post_data['description'] = $value->keterangan;
    //             $this->add($post_data);
    //         }
    //         $this->load->view('index', $data);
    //     }else{
    //         $next = $start + 500;
    //         //var_dump($data_import[0]);
    //         foreach ($data_import as $key => $value) {
    //             $post_data['asset_code'] = $value->kode_barang;
    //             $post_data['type'] = $value->jenis_barang;
    //             $post_data['register_number'] = $value->nomor_registrasi;
    //             $post_data['brand'] = $value->merk;
    //             $post_data['year_purchased'] = $value->tahun_pembelian;
    //             $post_data['color'] = $value->warna;
    //             $post_data['size'] = $value->ukuran;
    //             $post_data['material'] = $value->bahan;
    //             $post_data['factory_number'] = $value->nomor_pabrik;
    //             $post_data['chassis_number'] = $value->nomor_rangka;
    //             $post_data['machine_number'] = $value->nomor_mesin;
    //             $post_data['police_number'] = $value->nomor_polisi;
    //             $post_data['bpkb_number'] = $value->nomor_bpkb;
    //             $post_data['price'] = $value->harga;
    //             $post_data['agency_id'] = $this->get_agency_id($value->id_skpd);
    //             $post_data['origin'] = $value->asal_usul;
    //             $post_data['code_number'] = $value->no_kode;
    //             $post_data['description'] = $value->keterangan;
    //             $this->add($post_data);
    //         }
    //         redirect('dashboard/import_kib/'.$next);
    //     }
    // }
    // public function get_agency_id($val){

    //     $val = intval($val);
    //     //var_dump($val);
    //    if($val == 26){
    //        $num = 4;
    //    }elseif($val  ==  48 ){
    //        $num = 1;
    //    }elseif($val  ==  23){
    //        $num = 5;
    //    }
    //    return $num;
    // }
    // public function add($post_data)
    // {
        
    //     $insert = $this->m_assets->add($post_data);
    //     if ($insert) {
    //         $this->session->set_flashdata('alert', $this->alert->set_alert('info', 'Data berhasil di masukan ke database'));
    //     } else {
    //         $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data gagal di masukan ke database'));
    //     }
    //     return $insert;
    // }