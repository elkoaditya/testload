<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class buku_bab extends Member_Controller {

    function __construct() {
        parent::__construct();
		$d = & $this->d;
		 $this->load->model('data/mod_baca', 'mod_baca');
        $this->load->model('data/mod_buku_bab', 'mod_buku_bab');
		
		$this->load->model('data/mod_sdm', 'mod_sdm');
		$this->load->model('data/mod_siswa', 'mod_siswa');
		
        $this->load->helper('general/other/data/buku_bab');
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
		$data['data_buku_bab_aktif'] = $this->mod_buku_bab->listing($data);
		$data['pensiun'] = 1;
		$data['data_buku_bab_pensiun'] = $this->mod_buku_bab->listing($data);
		
		view_buku_bab1($data);
    }
	
	function detail($id) {
		
		$this->detail_html($id);
		
		///// DETAIL
		/*
		$data['id'] = $id; 
		$data['data_buku_bab'] = $this->mod_buku_bab->listing($data);
		
		$length = 18;
		$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		$data['kode_unik'] = $randomString;
		
		view_detailbuku_bab1($data);
		*/
    }
	
	function detail_new($id) {
		$this->detail_html($id);
		/*
		$data['id'] = $id; 
		$data['data_buku_bab'] = $this->mod_buku_bab->listing($data);
		
		$length = 18;
		$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		$data['kode_unik'] = $randomString;
		
		view_detailbuku_bab2($data);
		*/
    }
	
	function detail_html($id) {
		$data['id'] = $id; 
		$data['data_buku_bab'] = $this->mod_buku_bab->listing($data);
		
		$length = 18;
		$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		$data['kode_unik'] = $randomString;
		
		view_detailbuku_bab3($data);
    }
	
	function input_new($buku_id) {
		$data['id'] = ""; //$id;
		$data['buku_id'] = $buku_id; //$id;
		view_inputnew1($data);
    }
	
	function edit($id) {
		$data['id'] = $id; //$id;
		$data['data_buku_bab'] = $this->mod_buku_bab->listing($data);
		view_inputnew1($data);
    }
	
	function save() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		
		$upload = $this->upload_file('buku_bab_file', 'jpg|jpeg|png|pdf|gif', 'buku_bab');
		
		if ($this->mod_buku_bab->save($data,$upload)){
			return alert_success("Berhasil disimpan.", "data/buku/detail/".$data['buku_bab_buku_id']);
		}
		//redirect(base_url().'data/buku_bab');
	}
	
	function edit_pensiun() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		if ($this->mod_buku_bab->edit_pensiun($data)){
			return alert_success("Berhasil disimpan.", "data/buku_bab");
		}
		//redirect(base_url().'data/buku_bab');
    }
	
	function delete() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		if ($this->mod_buku_bab->delete($data)){
			return alert_success("Berhasil dihapus.", "data/buku_bab");
		}
		
		//redirect(base_url().'data/buku_bab');
    }
	
	function excel_input($action=""){
		$d = & $this->d;
		$data['pensiun'] = 0;
		$data['data_satuan'] = $this->mod_buku_bab->listing($data);
		
		//// SATUAN KOSONG
		if(isset($data['data_satuan']['data']))
		{	}
		else
		{	//redirect(base_url().'data/satuan');	
			return alert_error("Data Satuan kosong, harap di isi dahulu.", "data/buku_bab");
		}
		
		if($action=='download')
		{
			$this->mod_buku_bab->download_add($data);
		}
		
		if($action=='upload')
		{
			$upload = $this->upload_file('file', 'xls|xlsx', 'excel');
			
			if ($this->mod_buku_bab->upload_add($upload,$data))
			{
				//return redir("data/item");
				return alert_success("Barang berhasil disimpan.", "data/buku_bab");
			}
		}
		view_input_excel1();
		//$this->load->view('excel_tambah_buku');
		
	}
    
	/// RESUME
	function list_resume() {
		$data['user'] 		=  '';
		if($this->session->userdata['user']['role']!='super_admin'){
			$data['user'] 		= $this->session->userdata['user']['id']; 
		}
		$data['data_resume'] = $this->mod_buku_bab->list_resume($data);
		
		view_resume1($data);
    }
	
	function input_resume($buku_bab) {
		// data resume
		$data['buku_bab'] 	= $buku_bab; //$id;
		if($this->session->userdata['user']['role']!='super_admin'){
			$data['user'] 		= $this->session->userdata['user']['id']; 
		}
		$data['data_resume'] = $this->mod_buku_bab->list_resume($data);
		
		// data buku
		$data_buku_bab['id'] = $buku_bab; 
		$data['data_buku_bab'] = $this->mod_buku_bab->listing($data_buku_bab);
		
		// data user
		if($this->session->userdata['user']['role']=='guru'){
			$data_user['id'] 	= $this->session->userdata['user']['id']; 
			$data['data_user'] 	= $this->mod_sdm->listing($data_user);
			
		}elseif($this->session->userdata['user']['role']=='user'){
			$data_user['id'] 	= $this->session->userdata['user']['id']; 
			$data['data_user'] 	= $this->mod_siswa->listing($data_user);
			
		}
		
		view_inputresume1($data);
    }
	
	function save_resume() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		
		if ($this->mod_buku_bab->save_resume($data)){
			return alert_success("Berhasil disimpan.", "data/buku_bab/list_resume");
		}
		//redirect(base_url().'data/buku_bab');
	}
}
