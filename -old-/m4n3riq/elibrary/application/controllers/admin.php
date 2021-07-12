<?php

/**
 * User: Yusuf Fachrudin S
 * Date: 09/08/2015
 * CV. PINASTHIKA NURAGA
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
		
    }

    public function index() {
		
        redirect(base_url()."dashboard/login_admin");
	 
    }
	
	
}
