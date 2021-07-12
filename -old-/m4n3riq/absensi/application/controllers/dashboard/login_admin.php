<?php

/**
 * User: Yusuf Fachrudin S
 * Date: 09/08/2015
 * CV. PINASTHIKA NURAGA
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_admin extends Public_Controller {

    function __construct() {
        parent::__construct();
		
		$this->load->model('login/mod_login', 'mod_login');
        $this->load->model('login/mod_login_admin', 'mod_login_admin');
        $this->load->helper('general/other/dashboard/login');
	  $this->load->library('session');
	//	$d = & $this->d;
	//	$d =  $this->d;
    }

    public function index() {
		
        $this->home();
	  // echo $this->g;
    }
	
    function Home() {
		$data['data_project'] = '';//$this->mod_project->listing();
		view_login_admin1($data);
    }
    
	public function verifikasi()
	{
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		
		$verifikasi = $this->mod_login_admin->verifikasi($data);
		
		if($verifikasi!=''){
			//redirect(base_url().'dashboard/home',$verifikasi);
			redirect(base_url().'data/siswa',$verifikasi);
		}else{
			$this->session->sess_destroy();
			$data['data_project'] = '';
			view_login_admin1($verifikasi);
		}
	//	echo "<pre>";
	//	print_r( $this->session->all_userdata());
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
