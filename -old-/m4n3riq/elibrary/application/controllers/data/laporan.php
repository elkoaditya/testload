<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan extends Member_Controller {

    function __construct() {
        parent::__construct();
		$d = & $this->d;
        $this->load->model('data/mod_laporan', 'mod_laporan');
		$this->load->model('data/mod_siswa', 'mod_siswa');
		$this->load->model('data/mod_kelas', 'mod_kelas');
		
        $this->load->helper('general/other/data/laporan');
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
		$data = array();
		
		$data['data_kelas'] = $this->mod_kelas->listing();
		//$data['data_laporan'] = $this->mod_laporan->listing();
		
		view_laporan1($data);
    }
	
	function siswa_baca_excel($kelas, $bulan , $tahun){
		$d = & $this->d;
		
		$data['kelas_id'] 	= $kelas;
		$data['bulan'] 		= $bulan;
		$data['tahun'] 		= $tahun;
		
		$data['data_siswa'] = $this->mod_siswa->listing($data);
		$data['data_siswa_baca'] = $this->mod_laporan->listing_waktu($data);
		//print_r($data['data_siswa_baca'] );
		
		$data1['id'] 	= $kelas;
		$data['data_kelas'] 		= $this->mod_kelas->listing($data1);
		$this->mod_laporan->siswa_baca_excel($data);
	}
	/*
	function detail($id) {
		$data['id'] = $id; 
		$data['data_laporan'] = $this->mod_laporan->listing($data);
		view_detaillaporan1($data);
    }
	
	function input_new() {
		$data['id'] = ""; //$id;
		view_inputnew1($data);
    }
	
	function edit($id) {
		$data['id'] = $id; //$id;
		$data['data_laporan'] = $this->mod_laporan->listing($data);
		view_inputnew1($data);
    }
	
	function save() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
			
		if ($this->mod_laporan->save($data)){
			return alert_success("Berhasil disimpan.", "data/laporan");
		}
		//redirect(base_url().'data/laporan');
	}
	
	function edit_pensiun() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		if ($this->mod_laporan->edit_pensiun($data)){
			return alert_success("Berhasil disimpan.", "data/laporan");
		}
		//redirect(base_url().'data/laporan');
    }
	
	function delete() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		if ($this->mod_laporan->delete($data)){
			return alert_success("Berhasil dihapus.", "data/laporan");
		}
		
		//redirect(base_url().'data/laporan');
    }
	
	function excel_input($action=""){
		$d = & $this->d;
		$data['pensiun'] = 0;
		
		if($action=='download')
		{
			$this->mod_laporan->download_add();
		}
		
		if($action=='upload')
		{
			$upload = $this->upload_file('file', 'xls|xlsx', 'excel');
			
			if ($this->mod_laporan->upload_add($upload,$data))
			{
				//return redir("data/item");
				return alert_success("Barang berhasil disimpan.", "data/laporan");
			}
		}
		view_input_excel1();
		//$this->load->view('excel_tambah_buku');
		
	}*/
    
}
