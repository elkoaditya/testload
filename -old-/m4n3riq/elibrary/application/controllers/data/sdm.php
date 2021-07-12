<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class sdm extends Member_Controller {

    function __construct() {
        parent::__construct();
		$d = & $this->d;
        $this->load->model('data/mod_sdm', 'mod_sdm');
		$this->load->model('data/mod_grafik', 'mod_grafik');
		
        $this->load->helper('general/other/data/sdm');
		$this->load->helper('general/excel/excel');
		$this->load->helper('template/'.$d['data_setting']['template'].'/general/form');
		
	//	$d =  $this->d;
	//	print_r($d);
    }

    public function index() {
		
	//print_r($this->session->all_userdata());
       $this->home();
	  // echo $this->g;
    }
	
    function Home() {
		$data = '';
		if($this->input->get('kelas')!=0){
			$data['kelas_id'] = $this->input->get('kelas');
		}
		$data['data_sdm'] = $this->mod_sdm->listing($data);
		
		view_sdm1($data);
    }
	
	function detail($id) {
		
		//////////////////////////////////////////////////////////////////
		$data['id'] = $id; 
		$data['data_sdm'] 		= $this->mod_sdm->listing($data);
		
		$data['data_sdm_baca']	= $this->mod_sdm->listing_baca($data);
		
		//GRAFIK////////////////////////////////////////////////////////////////
		$data1['prd_ta'] = '2018/2019'; 
		$data1['sdm_id'] = $id; 
		$data['data_grafik'] = $this->mod_grafik->listing($data1, 'sdm');
		
		view_detailsdm1($data);
    }
	
	function edit($id) {
		$data['id'] = $id; //$id;
		$data['data_sdm'] 			= $this->mod_sdm->listing($data);
		
		view_inputnew1($data);
    }
	
	function save() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		
		$upload = $this->upload_file('sdm_perpus_foto', 'jpg|jpeg|png|pdf|gif', 'avatar');
		
		if ($this->mod_sdm->save($data, $upload)){
			return alert_success("Berhasil disimpan.", "data/sdm");
		}
		//redirect(base_url().'data/sdm');
	}
    
}
