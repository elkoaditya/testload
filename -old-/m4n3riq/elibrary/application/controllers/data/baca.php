<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Baca extends Member_Controller {

    function __construct() {
        parent::__construct();
		$d = & $this->d;
		$this->load->model('data/mod_baca', 'mod_baca');
		$this->load->helper('general/other/data/baca');
		$this->load->helper('general/excel/excel');
		$this->load->helper('template/'.$d['data_setting']['template'].'/general/form');
		
	//	$d =  $this->d;
	//	print_r($d);
    }
	
	 public function index() {
		
       $this->home();
    }
	
	function Home() {
		if($this->input->get('date')){
			$data['date'] = tgltodb($this->input->get('date'));
		}else{
			$data['date'] = date("Y-m-d");
		}
		$data['data_baca_siswa']	= $this->mod_baca->listing_detail($data,'siswa');
		$data['data_baca_sdm']		= $this->mod_baca->listing_detail($data,'sdm');
		
		view_baca1($data);
    }
	
	function save_time(){
		
		$response = $this->mod_baca->save_time();
		
		echo json_encode($response);      
		exit;
	}
	
	function baca_excel($tanggal){
		$d = & $this->d;
		
		$data['date'] 		= tgltodb($tanggal);
		
		$data['data_baca'] = $this->mod_baca->listing_detail($data);
		$this->mod_baca->baca_excel($data);
	}
	
}