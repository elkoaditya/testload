<?php

/**
 * User: Yusuf Fachrudin S
 * Date: 09/08/2015
 * CV. PINASTHIKA NURAGA
 */
if (!function_exists('view_loader')) {

    function view_login_admin1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
	//	$d['page_view'] = 'face/home';
	//	$d['page_view2'] = 'face/home_data';
	//$CI->_dump();
	//	print_r($d);
        $d['pages2'] = viewPathType1($d);
       // $CI->load->helper('template/'.templateView1($d).'table/bencana');
        view_loader1admin($d);
    }
	
	function view_login_siswa1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
	//	$d['page_view'] = 'face/home';
	//	$d['page_view2'] = 'face/home_data';
	//$CI->_dump();
	//	print_r($d);
        $d['pages2'] = viewPathType1($d);
       // $CI->load->helper('template/'.templateView1($d).'table/bencana');
        view_loader1($d);
    }
}