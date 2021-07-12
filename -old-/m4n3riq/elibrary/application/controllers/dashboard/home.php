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
		
        $this->load->helper('general/other/dashboard/home');
		$d = & $this->d;
	
    }

    public function index() {
		
	//print_r($this->session->all_userdata());
       $this->home();
	  // echo $this->g;
    }
	
    function Home() {
		$data ='';
		view_home1($data);
    }
    
}
