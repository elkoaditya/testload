<?php

/**
 * User: Yusuf Fachrudin S
 * Date: 09/08/2015
 * CV. PINASTHIKA NURAGA
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends Member_Controller {

    function __construct() {
        parent::__construct();
		
        //$this->load->helper('general/other/dashboard/home');
		$d = & $this->d;
		$this->load->model('data/mod_siswa', 'mod_siswa');
		
        $this->load->helper('general/other/data/siswa');
		$this->load->helper('template/'.$d['data_setting']['template'].'/general/form');
	
    }

    public function index() {
		
	//print_r($this->session->all_userdata());
       $this->home();
	  // echo $this->g;
    }
	
	function Home() {
		$data['data_siswa'] = $this->mod_siswa->listing();
		view_siswa1($data);
    }
	
	function detail($id) {
		$data['id'] = $id; 
		$data['data_siswa'] 				= $this->mod_siswa->listing($data);
		view_detailsiswa1($data);
    }
	
	function input_new() {
		$data['id'] = ""; //$id;
		view_inputnew1($data);
    }
	
	function edit($id) {
		$data['id'] = $id; //$id;
		$data['data_siswa'] 				= $this->mod_siswa->listing($data);
		view_inputnew1($data);
    }
	
	function save() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
			$this->mod_siswa->save($data);
		
		redirect(base_url().'data/siswa');
	}
	
	function print_surat($id) {
		$data['id'] = $id; 
		$data['data_siswa'] 				= $this->mod_siswa->listing($data);
		
		$body = print_siswa1($data, TRUE);
		//$body = $this->load->view("zircos/data/print_siswa", $data, TRUE);
		//$data['page_content'] = $this->load->view("zircos/data/print_siswa", $data, true);
		//$body = $this->load->view("zircos/general/page/allpage3", $data, true);
		
		$key = $data['data_siswa']['data'][1];
		
		$nama_file = "siswa_no_".$key['siswa_no1']."_".$key['siswa_no2']."_".
				$key['siswa_bulan']."_".$key['siswa_tahun'];
		
			//print_r($data['data_siswa']);
		return $this->_pdf($body, $nama_file);
	}
	
	function delete() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		if ($this->mod_siswa->delete($data)){
			return alert_success("Berhasil dihapus.", "data/siswa");
		}
    }
    
}
