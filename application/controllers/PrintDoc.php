<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Printdoc extends CI_Controller {
        private $url = 'dashboard';

        public function __construct()
        {
            parent::__construct();
            $this->load->library('pdf');
        }
        
        public function index($id=null)
        {
            // if($id==null) redirect(site_url($this->url));
            // $this->load->model('m_templates');
            // $template = $this->m_templates->getWhere(array('name'=>'bebas_aset'))[0]->template;

            // $perihal = $this->input->get('perihal');
            // if($perihal==null) $perihal = '';

            // $data['print'] = $template;
            // $data['officer'] = $this->officer_data($id);
            // $data['agency'] = $this->agency_data($data['officer']->agency_id);
            // $data['perihal'] = $perihal;

            // $html = $this->load->view('page/setting/print_placeholder',$data,true);
            
            // //echo $html;

            // $this->dompdf->loadHTML($html);
            // // (Optional) Setup the paper size and orientation
            // $this->dompdf->setPaper('letter', 'potrait');

            // // Render the HTML as PDF
            // $this->dompdf->render();

            // // Output the generated PDF (1 = download and 0 = preview)
            // $this->dompdf->stream("welcome.pdf", array("Attachment" => 0));
        }

    public function usulan($agency_id=4)
    {
        $agency_id = $this->session->agency_id;

        $this->load->model('m_templates');
        $template = $this->m_templates->getWhere(array('name' => 'usulan'))[0]->template;

        $perihal = $this->input->get('perihal');
        if ($perihal == null) $perihal = '';

        $data['print'] = $template;
        $data['agency'] = $this->agency_data($agency_id);
        $data['perihal'] = $perihal;

        $html = $this->load->view('page/setting/print_placeholder', $data, true);

        //echo $html;

        $this->dompdf->loadHTML($html);
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('letter', 'potrait');

        // Render the HTML as PDF
        $this->dompdf->render();

        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("welcome.pdf", array("Attachment" => 0));
    }

    public function keterangan($agency_id = 4)
    {

        $agency_id = $this->session->agency_id;

        $this->load->model('m_templates');
        $template = $this->m_templates->getWhere(array('name' => 'keterangan'))[0]->template;

        $perihal = $this->input->get('perihal');
        if ($perihal == null) $perihal = '';

        $data['print'] = $template;
        $data['agency'] = $this->agency_data($agency_id);
        $data['perihal'] = $perihal;

        $html = $this->load->view('page/setting/print_keterangan', $data, true);

        //echo $html;

        $this->dompdf->loadHTML($html);
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('letter', 'potrait');

        // Render the HTML as PDF
        $this->dompdf->render();

        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("welcome.pdf", array("Attachment" => 0));
    }

    public function lampiran($type='gambar')
    {

        $agency_id = $this->session->agency_id;
        $this->load->model('m_assets');
        $this->load->model('m_templates');
        $template = $this->m_templates->getWhere(array('name' => 'lampiran_gambar'))[0]->template;
        $agency_data = $this->agency_data($agency_id);

        $data['print'] = $template;
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
        $data['table_content'] = $this->m_assets->fetch($fetch);
       

       

        if($type=='gambar'){
            //echo $html;
            $html = $this->load->view('page/setting/print_gambar', $data, true);
            $this->dompdf->loadHTML($html);
            // (Optional) Setup the paper size and orientation
            $this->dompdf->setPaper('letter', 'potrait');

            // Render the HTML as PDF
            $this->dompdf->render();
            
            // Output the generated PDF (1 = download and 0 = preview)
            $this->dompdf->stream("DOKUMENTASI FOTO FISIK BARANG - ".strtoupper($agency_data->name).".pdf", array("Attachment" => 0));
        }else{
           $data['agency_data']= $agency_data;
           $this->load->view('page/setting/print_aset', $data);
           
        }
    }
       

        private function officer_data($id){
            $this->load->model('m_officers');
            $officer_data = $this->m_officers->getWhere(array('id'=>$id));
            if(count($officer_data)>0){
               return $officer_data[0];
            }else{
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data asn tidak ditemukan di database'));
                redirect(site_url($this->url));
               
            }
        }

        private function agency_data($id)
        {
            $this->load->model('m_agencies');

            $fetch['select'] = array('*');
            $fetch['select_join'] = array(
                'hod.full_name as nama_kadis',
                'hod.nip as nip_kadis',
                'hod.rank as pangkat_kadis',
                'hod.position as jabatan_kadis',
                'ao.full_name as pengurus_barang',
                'ao.nip as nip_pebar',
            );
            $fetch['join'] = array(
                array(
                    "table" => "officers hod",
                    "join" => "left",
                    "on" => "hod.id = agencies.hod_id"
                ), array(
                    "table" => "officers ao",
                    "join" => "left",
                    "on" => "ao.id = agencies.ao_id"
                ),
            );
            $fetch['where'] = [];
            array_push($fetch['where'],array('agencies.id'=>$id));
            $agency_data = $this->m_agencies->fetch($fetch);
            
            if (count($agency_data) > 0) {
                return $agency_data[0];
            } else {
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'Data agency tidak ditemukan di database'));
                //redirect(site_url($this->url));
                
            }
        }
    
    }
    
    /* End of file PrintDoc.php */
    

?>