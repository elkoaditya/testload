<?php

if (!function_exists('view_loader')) {

    function view_laporan1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/laporan';
	//	$d['page_view2'] = 'face/home_data';
	//$CI->_dump();
	//	print_r($d);
        $d['pages2'] = viewPathTypeTable($d);
       // $CI->load->helper('template/'.templateView1($d).'table/bencana');
        view_loader2($d);
    }
	function view_laporan2($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/laporan_listcover';
        $d['pages2'] = viewPathTypeTable($d);
       
        view_loader2($d);
    }
	function view_detaillaporan1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/laporan_detail';
        $d['pages2'] = viewPathType1($d);
        view_loader2($d);
    }
    function view_inputnew1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/laporan_input';
        $d['pages2'] = viewPathTypeFormAdv($d);
        view_loader2($d);
    }
	function view_input_excel1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/laporan_input_excel';
        $d['pages2'] = viewPathTypeFormAdv($d);
        view_loader2($d);
    }
}