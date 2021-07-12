<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class buku extends Member_Controller {

    function __construct() {
        parent::__construct();
		$d = & $this->d;
        $this->load->model('data/mod_buku', 'mod_buku');
		$this->load->model('data/mod_buku_bab', 'mod_buku_bab');
		$this->load->model('data/mod_tag', 'mod_tag');
		$this->load->model('data/mod_grafik', 'mod_grafik');
		
        $this->load->helper('general/other/data/buku');
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
		$data['pensiun'] = 0;
		$data['data_buku_aktif'] = $this->mod_buku->listing($data);
		$data['pensiun'] = 1;
		$data['data_buku_pensiun'] = $this->mod_buku->listing($data);
		
		view_buku1($data);
    }
	
	function listcover($limit=18 , $offset=0) {
		foreach ($_GET as $key => $value)
		{
			$data1[$key] = $value;
		}
		$data1['data_tag'] 	= $this->mod_tag->listing();
		$data1['pensiun'] = 0;
		$data['max_buku'] = $this->mod_buku->listing($data1);
		
		////////
		$data1['limit'] = $limit;
		$data1['offset'] = $offset;
		$data['data_buku'] 	= $this->mod_buku->listing($data1);
		
		//////////////////
		$data['data_tag']	= $data1['data_tag'];
		$data['limit'] 	= $limit;
		$data['offset'] = $offset;
		
		view_buku2($data);
    }
	
	function listcover_simple($limit=20 , $offset=0) {
		foreach ($_GET as $key => $value)
		{
			$data1[$key] = $value;
		}
		$data1['data_tag'] 	= $this->mod_tag->listing();
		$data1['pensiun'] = 0;
		$data['max_buku'] = $this->mod_buku->listing($data1);
		
		////////
		$data1['limit'] = $limit;
		$data1['offset'] = $offset;
		$data['data_buku'] 	= $this->mod_buku->listing($data1);
		
		//////////////////
		$data['data_tag']	= $data1['data_tag'];
		$data['limit'] 	= $limit;
		$data['offset'] = $offset;
		
		view_buku3($data);
    }
	
	function detail($id) {
		$data['id'] = $id; 
		$data['data_buku'] = $this->mod_buku->listing($data);
		
		if($this->session->userdata['user']['role'] == 'user')
		{	
			$data['siswa_id'] 		= $this->session->userdata['user']['id'];
			$data2['siswa_id'] 		= $data['siswa_id'];			
		}
		
		if($this->session->userdata['user']['role'] == 'guru')
		{	
			$data['sdm_id'] 		= $this->session->userdata['user']['id'];	
			$data2['sdm_id'] 		= $data['sdm_id'];				
		}
	
		$data['data_buku_baca_siswa']	= $this->mod_buku->listing_baca($data,'siswa');
		$data['data_buku_baca_sdm']		= $this->mod_buku->listing_baca($data,'sdm');
		
		$data1['buku_id'] = $id; 
		$data['data_buku_bab'] = $this->mod_buku_bab->listing($data1);
		
		//GRAFIK////////////////////////////////////////////////////////////////
		$data2['prd_ta'] = '2018/2019'; 
		$data2['buku_id'] = $id; 
		$data['data_grafik_siswa'] = $this->mod_grafik->listing($data2,'siswa');
		$data['data_grafik_sdm'] = $this->mod_grafik->listing($data2,'sdm');
		
		view_detailbuku1($data);
    }
	
	function input_new() {
		$data['id'] = ""; //$id;
		$data['data_tag'] 		= $this->mod_tag->listing();
		view_inputnew1($data);
    }
	
	function edit($id) {
		$data['id'] = $id; //$id;
		$data['data_tag'] 			= $this->mod_tag->listing();
		
		$data['data_buku'] 			= $this->mod_buku->listing($data);
		$data['data_buku_tag']		= $this->mod_buku->listing_tag($data);
		
		
		view_inputnew1($data);
    }
	
	function save() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		
		$upload = $this->upload_file('buku_cover', 'jpg|jpeg|png|pdf|gif', 'cover');
		
		if ($this->mod_buku->save($data, $upload)){
			return alert_success("Berhasil disimpan.", "data/buku");
		}
		//redirect(base_url().'data/buku');
	}
	
	function edit_pensiun() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		if ($this->mod_buku->edit_pensiun($data)){
			return alert_success("Berhasil disimpan.", "data/buku");
		}
		//redirect(base_url().'data/buku');
    }
	
	function delete() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		if ($this->mod_buku->delete($data)){
			return alert_success("Berhasil dihapus.", "data/buku");
		}
		
		//redirect(base_url().'data/buku');
    }
	
	function excel_input($action=""){
		$d = & $this->d;
		$data['pensiun'] = 0;
		
		if($action=='download')
		{
			$this->mod_buku->download_add();
		}
		
		if($action=='upload')
		{
			$upload = $this->upload_file('file', 'xls|xlsx', 'excel');
			
			if ($this->mod_buku->upload_add($upload,$data))
			{
				//return redir("data/item");
				return alert_success("Berhasil disimpan.", "data/buku");
			}
		}
		view_input_excel1();
		//$this->load->view('excel_tambah_buku');
		
	}
    
}
