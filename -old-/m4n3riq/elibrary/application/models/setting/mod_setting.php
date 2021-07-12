<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_setting extends CI_Model {

    function all_set() {
		$d = array(
				'template' => 'zircos',
				'db_set' => '',
				//'template' => 'blur',
			);
        return $d;
    }
	

}
