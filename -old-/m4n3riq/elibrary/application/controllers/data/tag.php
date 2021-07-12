<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tag extends Member_Controller {

    function __construct() {
        parent::__construct();
		$d = & $this->d;
        $this->load->model('data/mod_tag', 'mod_tag');
        $this->load->helper('general/other/data/tag');
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
		
		$data['data_tag'] = $this->mod_tag->listing();
		
		view_tag1($data);
    }
	
	function detail($id) {
		$data['id'] = $id; 
		$data['data_tag'] = $this->mod_tag->listing($data);
		view_detailtag1($data);
    }
	
	function input_new() {
		$data['id'] = ""; //$id;
		view_inputnew1($data);
    }
	
	function edit($id) {
		$data['id'] = $id; //$id;
		$data['data_tag'] = $this->mod_tag->listing($data);
		view_inputnew1($data);
    }
	
	function save() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
			
		if ($this->mod_tag->save($data)){
			return alert_success("Berhasil disimpan.", "data/tag");
		}
		//redirect(base_url().'data/tag');
	}
	
	function edit_pensiun() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		if ($this->mod_tag->edit_pensiun($data)){
			return alert_success("Berhasil disimpan.", "data/tag");
		}
		//redirect(base_url().'data/tag');
    }
	
	function delete() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		if ($this->mod_tag->delete($data)){
			return alert_success("Berhasil dihapus.", "data/tag");
		}
		
		//redirect(base_url().'data/tag');
    }
	
	function excel_input($action=""){
		$d = & $this->d;
		$data['pensiun'] = 0;
		
		if($action=='download')
		{
			$this->mod_tag->download_add();
		}
		
		if($action=='upload')
		{
			$upload = $this->upload_file('file', 'xls|xlsx', 'excel');
			
			if ($this->mod_tag->upload_add($upload,$data))
			{
				//return redir("data/item");
				return alert_success("Barang berhasil disimpan.", "data/tag");
			}
		}
		view_input_excel1();
		//$this->load->view('excel_tambah_buku');
		
	}
    
}
