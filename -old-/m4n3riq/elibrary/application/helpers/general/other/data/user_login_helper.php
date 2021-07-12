<?php

if (!function_exists('view_loader')) {

    function view_user_login1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/user_login';
	//	$d['page_view2'] = 'face/home_data';
	//$CI->_dump();
	//	print_r($d);
        $d['pages2'] = viewPathTypeTable($d);
       // $CI->load->helper('template/'.templateView1($d).'table/bencana');
        view_loader2($d);
    }
	function view_detailuser_login1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/user_login_detail';
        $d['pages2'] = viewPathType1($d);
        view_loader2($d);
    }
    function view_inputnew1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/user_login_input';
        $d['pages2'] = viewPathTypeForm($d);
        view_loader2($d);
    }
}