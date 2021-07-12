<?php

/**
 * User: Yusuf Fachrudin S
 * Date: 09/08/2015
 * CV. PINASTHIKA NURAGA
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Siswa extends Member_Controller {

    function __construct() {
        parent::__construct();
		
        //$this->load->helper('general/other/dashboard/home');
		$d = & $this->d;
		$this->load->model('data/mod_siswa', 'mod_siswa');
		$this->load->model('data/mod_alasan_sekolah', 'mod_alasan_sekolah');
		$this->load->model('data/mod_setelah_lulus', 'mod_setelah_lulus');
		
        $this->load->helper('general/other/data/siswa');
		$this->load->helper('general/excel/excel');
		$this->load->helper('template/'.$d['data_setting']['template'].'/general/form');
	
    }

    public function index() {
		
	//print_r($this->session->all_userdata());
       $this->home();
	  // echo $this->g;
    }
	
	function Home() {
		//$data['data_siswa'] = $this->mod_siswa->listing();
		$data['data_siswa'] ='';
		view_siswa1($data);
    }
	
	function detail($id) {
		$data['id'] = $id; 
		$data['data_siswa'] 			= $this->mod_siswa->listing($data);
		$data['data_siswa_prestasi'] 	= $this->mod_siswa->listing_prestasi($data);
		$data['data_siswa_kuliah'] 		= $this->mod_siswa->listing_kuliah($data);
		$data['data_siswa_kerja'] 		= $this->mod_siswa->listing_kerja($data);
		$data['data_siswa_alasan_sekolah'] 	= $this->mod_siswa->listing_alasan_sekolah($data);
		
		$data['data_alasan_sekolah'] 	= $this->mod_alasan_sekolah->listing();
		$data['data_setelah_lulus'] 	= $this->mod_setelah_lulus->listing();
		
		view_detailsiswa1($data);
    }
	
	function input_new() {
		$data['id'] = ""; //$id;
		
		$data['data_alasan_sekolah'] 	= $this->mod_alasan_sekolah->listing();
		$data['data_setelah_lulus'] 	= $this->mod_setelah_lulus->listing();
		view_inputnew1($data);
    }
	
	function edit($id) {
		$data['id'] = $id; //$id;
		$data['data_siswa'] 			= $this->mod_siswa->listing($data);
		$data['data_siswa_prestasi'] 	= $this->mod_siswa->listing_prestasi($data);
		$data['data_siswa_kuliah'] 		= $this->mod_siswa->listing_kuliah($data);
		$data['data_siswa_kerja'] 		= $this->mod_siswa->listing_kerja($data);
		$data['data_siswa_alasan_sekolah'] 	= $this->mod_siswa->listing_alasan_sekolah($data);
		
		$data['data_alasan_sekolah'] 	= $this->mod_alasan_sekolah->listing();
		$data['data_setelah_lulus'] 	= $this->mod_setelah_lulus->listing();
		
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
		$data['data_siswa'] 			= $this->mod_siswa->listing($data);
		$data['data_siswa_prestasi'] 	= $this->mod_siswa->listing_prestasi($data);
		$data['data_siswa_kuliah'] 		= $this->mod_siswa->listing_kuliah($data);
		$data['data_siswa_kerja'] 		= $this->mod_siswa->listing_kerja($data);
		$data['data_siswa_alasan_sekolah'] 	= $this->mod_siswa->listing_alasan_sekolah($data);
		
		$data['data_alasan_sekolah'] 	= $this->mod_alasan_sekolah->listing();
		$data['data_setelah_lulus'] 	= $this->mod_setelah_lulus->listing();
		
		$body = print_siswa1($data, TRUE);
		//$body = $this->load->view("zircos/data/print_siswa", $data, TRUE);
		//$data['page_content'] = $this->load->view("zircos/data/print_siswa", $data, true);
		//$body = $this->load->view("zircos/general/page/allpage3", $data, true);
		
		$key = $data['data_siswa']['data'][1];
		
		$nama_file = 'Daftar_ulang_'.$key['siswa_nama']."_".$key['siswa_no_peserta'];
		
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
	
	function excel_input($action=""){
		$d = & $this->d;
		$data['pensiun'] = 0;
		
		if($action=='download')
		{
			$this->mod_siswa->download_add();
		}
		
		if($action=='upload')
		{
			$upload = $this->upload_file('file', 'xls|xlsx', 'excel');
			
			if ($this->mod_siswa->upload_add($upload,$data))
			{
				//return redir("data/siswa");
				return alert_success("Siswa berhasil disimpan.", "data/siswa");
			}
		}
		view_input_excel1();
		//$this->load->view('excel_tambah_buku');
		
	}
	
	function excel_download($action=""){
		//$d = & $this->d;
		
		$data['data_siswa'] 			= $this->mod_siswa->listing();
		/*$data['data_siswa_prestasi'] 	= $this->mod_siswa->listing_prestasi();
		$data['data_siswa_kuliah'] 		= $this->mod_siswa->listing_kuliah();
		$data['data_siswa_kerja'] 		= $this->mod_siswa->listing_kerja();
		$data['data_siswa_alasan_sekolah'] 	= $this->mod_siswa->listing_alasan_sekolah();
		
		$data['data_alasan_sekolah'] 	= $this->mod_alasan_sekolah->listing();
		$data['data_setelah_lulus'] 	= $this->mod_setelah_lulus->listing();*/
		
		
		if($action=='download')
		{
			$this->mod_siswa->download_data($data);
		}
		
		
	}
    
}
