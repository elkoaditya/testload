<?php

if (!function_exists('view_loader')) {

    function view_grafik1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/grafik';
	//	$d['page_view2'] = 'face/home_data';
	//$CI->_dump();
	//	print_r($d);
        $d['pages2'] = viewPathTypeForm($d);
       // $CI->load->helper('template/'.templateView1($d).'table/bencana');
        view_loader2($d);
    }
	function view_detailgrafik1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/grafik_detail';
        $d['pages2'] = viewPathType1($d);
        view_loader2($d);
    }
    function view_inputnew1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/grafik_input';
        $d['pages2'] = viewPathTypeForm($d);
        view_loader2($d);
    }
	function view_input_excel1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/grafik_input_excel';
        $d['pages2'] = viewPathTypeFormAdv($d);
        view_loader2($d);
    }
}