<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user_login extends Member_Controller {

    function __construct() {
        parent::__construct();
		$d = & $this->d;
        $this->load->model('data/mod_user_login', 'mod_user_login');
		$this->load->model('data/mod_user_login_role', 'mod_user_login_role');
        $this->load->helper('general/other/data/user_login');
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
		$data['data_user_login'] = $this->mod_user_login->listing();
		view_user_login1($data);
    }
	
	function detail($id) {
		$data['id'] = $id; 
		$data['data_user_login'] = $this->mod_user_login->listing($data);
		view_detailuser_login1($data);
    }
	
	function input_new() {
		$data['id'] = ""; //$id;
		$data['data_user_login_role'] = $this->mod_user_login_role->listing();
		view_inputnew1($data);
    }
	
	function edit($id) {
		$data['id'] = $id; //$id;
		$data['data_user_login'] = $this->mod_user_login->listing($data);
		$data['data_user_login_role'] = $this->mod_user_login_role->listing();
		view_inputnew1($data);
    }
	
	function save() {
		$data = array();
		foreach ($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
			$this->mod_user_login->save($data);
		
		redirect(base_url().'data/user_login');
	}
	
    
}
