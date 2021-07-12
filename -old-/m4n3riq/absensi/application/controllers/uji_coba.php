<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class uji_coba extends CI_Controller {

	public function index(){
		
		$this->load->view('zircos/uji_coba/absen_kelas');
	}
	
	public function index2(){
		
		$this->load->view('zircos/uji_coba/absen_siswa');
	}
	
	public function index3(){
		
		$this->load->view('zircos/uji_coba/jurnal');
	}
	
	public function index4(){
		
		$this->load->view('zircos/uji_coba/jurnal_update');
	}
	
	public function index5(){
		
		$this->load->view('zircos/uji_coba/jurnal_delete');
	}
	
	public function index6(){
		
		$this->load->view('zircos/uji_coba/absen_kelas_delete');
	}
	
	public function index7(){
		
		$this->load->view('zircos/uji_coba/absen_kelas_update');
	}
	
	public function index8(){
		
		$this->load->view('zircos/uji_coba/insert_pengumuman_read');
	}
	
	public function index9(){
		
		$this->load->view('zircos/uji_coba/jurnal_siswa');
	}
	
	public function index10(){
		
		$this->load->view('zircos/uji_coba/jurnal_siswa_update');
	}
	
	public function index11(){
		
		$this->load->view('zircos/uji_coba/jurnal_siswa_delete');
	}

	public function index12(){
		
		$this->load->view('zircos/uji_coba/verication_kode');
	}
}
?>