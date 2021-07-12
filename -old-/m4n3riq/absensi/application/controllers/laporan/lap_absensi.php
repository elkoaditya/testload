<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lap_absensi extends Member_Controller {

    function __construct() {
        parent::__construct();
		
        //$this->load->helper('general/other/dashboard/home');
		$d = & $this->d;
		$this->load->model('laporan/mod_lap_absensi', 'mod_lap_absensi');
		$this->load->model('laporan/mod_jam_ajar', 'mod_jam_ajar');
		$this->load->model('laporan/mod_kelas', 'mod_kelas');
		$this->load->model('laporan/mod_siswa', 'mod_siswa');
		
        $this->load->helper('general/other/laporan/lap_absensi');
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
		}
		
		//$data['tanggal'] = '"2018-07-26"';
		//$data['kelas_id'] = '57';
		
		$data['data_lap_absensi'] 		= $this->mod_lap_absensi->listing($data);
		
		$data['data_siswa'] 			= $this->mod_siswa->listing($data);
		
		$data['data_jam_ajar'] 			= $this->mod_jam_ajar->listing();
		$data['data_kelas'] 			= $this->mod_kelas->listing();
		
		
		view_lap_absensi1($data);
    }
	
	function excel_download($action=""){
		//$d = & $this->d;
		if($this->input->get('tanggal')){
			$data['tanggal'] = tgltodb($this->input->get('tanggal'));
		}else{
			$data['tanggal'] = date("Y-m-d");
		}
		
		$data['data_kelas'] 			= $this->mod_kelas->listing();
		
		$data['kelas_nama'] = '';
		if($this->input->get('kelas')!=0){
			$data['kelas_id'] = $this->input->get('kelas');
			
			foreach($data['data_kelas']['data'] as $value=>$key){
				if($data['kelas_id'] == $key['id'])
				{	$data['kelas_nama'] = $key['nama'];	}
			}
		}
		
		$data['data_lap_absensi'] 		= $this->mod_lap_absensi->listing($data);
		$data['data_siswa'] 			= $this->mod_siswa->listing($data);
		$data['data_jam_ajar'] 			= $this->mod_jam_ajar->listing();
		
		
		if($action=='download')
		{
			$this->mod_lap_absensi->download_data($data);
		}
		
		
	}
	
	function excel_download_rekap($action=""){
		//$d = & $this->d;
		if($this->input->get('tanggal')){
			$tanggal = tgltodb($this->input->get('tanggal'));
			$array_tanggal = explode( "-", $tanggal);
			$data['bulan'] = $array_tanggal[1];
			$data['tahun'] = $array_tanggal[0];
		}else{
			$data['bulan'] = date("m");
			$data['tahun'] = date("Y");
		}
		
		//echo "aaa ".$data['bulan']." ".$data['tahun'];
		
		$data['data_kelas'] 			= $this->mod_kelas->listing();
		
		$data['kelas_nama'] = '';
		if($this->input->get('kelas')!=0){
			$data['kelas_id'] = $this->input->get('kelas');
			
			foreach($data['data_kelas']['data'] as $value=>$key){
				if($data['kelas_id'] == $key['id'])
				{	$data['kelas_nama'] = $key['nama'];	}
			}
		}
		
		$data['data_lap_absensi'] 		= $this->mod_lap_absensi->listing($data);
		$data['data_siswa'] 			= $this->mod_siswa->listing($data);
		$data['data_jam_ajar'] 			= $this->mod_jam_ajar->listing();
		
		//print_r($data['data_lap_absensi']);
		
		if($action=='download')
		{
			$this->mod_lap_absensi->download_data_rekap($data);
		}
		
		
	}
    
}
