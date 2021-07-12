<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lap_jurnal_siswa extends Member_Controller {

    function __construct() {
        parent::__construct();
		
      
		$d = & $this->d;
		$this->load->model('laporan/mod_lap_jurnal_siswa', 'mod_lap_jurnal_siswa');
		$this->load->model('laporan/mod_jam_ajar', 'mod_jam_ajar');
		$this->load->model('laporan/mod_kelas', 'mod_kelas');
		$this->load->model('laporan/mod_status_belajar', 'mod_status_belajar');
		
        $this->load->helper('general/other/laporan/lap_jurnal_siswa');
		$this->load->helper('general/excel/excel');
		$this->load->helper('template/'.$d['data_setting']['template'].'/general/form');
	
    }

    public function index() {
		
	//print_r($this->session->all_userdata());
       $this->home();
	  // echo $this->g;
    }
	
	function Home() {
		
		if($this->input->get('tanggal')){
			$data['tanggal'] = tgltodb($this->input->get('tanggal'));
		}else{
			$data['tanggal'] = date("Y-m-d");
		}
		
		if($this->input->get('kelas')!=0){
			$data['kelas_id'] = $this->input->get('kelas');
			$data1['id'] = $data['kelas_id'];
		}
		
		$data['data_lap_jurnal_siswa'] 	= $this->mod_lap_jurnal_siswa->listing($data);
		$data['data_kelas'] 			= $this->mod_kelas->listing();
		
		$data['data_jam_ajar'] 			= $this->mod_jam_ajar->listing();
		$data['data_status_belajar'] 	= $this->mod_status_belajar->listing();
		
		/// data absensi
		$data['absen'] = 'm';
		$data['data_masuk'] 	= $this->mod_lap_jurnal_siswa->listing_jml_absen($data);
		
		$data['absen'] = 's';
		$data['data_sakit'] 	= $this->mod_lap_jurnal_siswa->listing_jml_absen($data);
		
		$data['absen'] = 'i';
		$data['data_ijin'] 		= $this->mod_lap_jurnal_siswa->listing_jml_absen($data);
		
		$data['absen'] = 'a';
		$data['data_alpha'] 	= $this->mod_lap_jurnal_siswa->listing_jml_absen($data);
		
		view_lap_jurnal_siswa1($data);
    }
	
	function excel_download($action=""){
		//$d = & $this->d;
		if($this->input->get('tanggal')){
			$data['tanggal'] = tgltodb($this->input->get('tanggal'));
		}else{
			$data['tanggal'] = date("Y-m-d");
		}
		
		$data['data_kelas'] 			= $this->mod_kelas->listing();
		$data_kelas = $data['data_kelas']['data'];
		$data['kelas_nama'] = '';
		$data['kelas_id'] = '';
		if($this->input->get('kelas')!=0){
			$data['kelas_id'] = $this->input->get('kelas');
			
			foreach($data_kelas as $value=>$key){
				if($data['kelas_id'] == $key['id'])
				{	$data['kelas_nama'] = $key['nama'];	}
			}
		}
		
		$data['data_lap_jurnal_siswa'] 	= $this->mod_lap_jurnal_siswa->listing($data);
		$data['data_status_belajar'] 	= $this->mod_status_belajar->listing();
		
		/// data absensi
		$data['absen'] = 'm';
		$data['data_masuk'] 	= $this->mod_lap_jurnal_siswa->listing_jml_absen($data);
		
		$data['absen'] = 's';
		$data['data_sakit'] 	= $this->mod_lap_jurnal_siswa->listing_jml_absen($data);
		
		$data['absen'] = 'i';
		$data['data_ijin'] 		= $this->mod_lap_jurnal_siswa->listing_jml_absen($data);
		
		$data['absen'] = 'a';
		$data['data_alpha'] 	= $this->mod_lap_jurnal_siswa->listing_jml_absen($data);
		
		if($action=='download')
		{
			$this->mod_lap_jurnal_siswa->download_data($data);
		}
		
		
	}
    
}
