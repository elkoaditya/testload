<?php

if (!function_exists('view_loader')) {

    function view_buku_bab1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/buku_bab';
	//	$d['page_view2'] = 'face/home_data';
	//$CI->_dump();
	//	print_r($d);
        $d['pages2'] = viewPathTypeTable($d);
       // $CI->load->helper('template/'.templateView1($d).'table/bencana');
        view_loader2($d);
    }
	function view_detailbuku_bab1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/buku_bab_detail';
        $d['pages2'] = viewPathType1($d);
        view_loader2($d);
    }
	function view_detailbuku_bab2($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/buku_bab_detail_new';
        $d['pages2'] = viewPathType1($d);
        view_loader2($d);
    }
	function view_detailbuku_bab3($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/buku_bab_detail_html';
        $d['pages2'] = viewPathType1($d);
        view_loader2($d);
    }
    function view_inputnew1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/buku_bab_input';
        $d['pages2'] = viewPathTypeFormAdv($d);
        view_loader2($d);
    }
	function view_input_excel1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/buku_bab_input_excel';
        $d['pages2'] = viewPathTypeFormAdv($d);
        view_loader2($d);
    }
	
	function view_resume1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/buku_bab_resume';
        $d['pages2'] = viewPathTypeTable($d);
        view_loader2($d);
    }
	function view_inputresume1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/buku_bab_resume_input';
        $d['pages2'] = viewPathTypeFormAdv($d);
        view_loader2($d);
    }
}