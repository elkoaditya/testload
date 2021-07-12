<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class grafik extends Member_Controller {

    function __construct() {
        parent::__construct();
		$d = & $this->d;
        $this->load->model('data/mod_grafik', 'mod_grafik');
		$this->load->model('data/mod_tag', 'mod_tag');
		
        $this->load->helper('general/other/data/grafik');
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
	
    function Home($role = 'siswa') {
		foreach ($_GET as $key => $value)
		{
			$data[$key] = $value;
		}
		
		$data['prd_ta'] = '2018/2019';
		
		
		if($role == 'siswa'){
			$data['role']	= $role;
			$data['data_grafik'] = $this->mod_grafik->listing($data, 'siswa');
		}
		if($role == 'sdm'){
			$data['role']	= 'guru';
			$data['data_grafik'] = $this->mod_grafik->listing($data, 'sdm');
		}
		////////////////////////////////////////////////////////////////////////////////
		
		$data['group'] = 'grade';
		$data['listing_peringkat_grade'] = $this->mod_grafik->listing_peringkat2($data);
		
		$data['group'] = 'tag';
		$data['data_tag'] = $this->mod_tag->listing();
		$data['listing_peringkat_tag'] = $this->mod_grafik->listing_peringkat2($data);
		
		///////////////////////////////////////////////////////////////////////////////
		$data['limit'] = 20;
		$data['group'] = 'user';
		if($role == 'siswa'){
			$data['listing_peringkat_user'] = $this->mod_grafik->listing_peringkat($data, 'siswa');
			
			$data['group'] = 'buku';
			$data['listing_peringkat_buku'] = $this->mod_grafik->listing_peringkat($data, 'siswa');
		}
		if($role == 'sdm'){
			$data['listing_peringkat_user'] = $this->mod_grafik->listing_peringkat($data, 'sdm');
			
			$data['group'] = 'buku';
			$data['listing_peringkat_buku'] = $this->mod_grafik->listing_peringkat($data, 'sdm');
		}
		
		
		
		
		view_grafik1($data);
    }
	
	function detail($id) {
		$data['id'] = $id; 
		
		$data['data_grafik'] = $this->mod_grafik->listing($data);
		view_detailgrafik1($data);
    }
	
	
    
}
