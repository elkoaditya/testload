<?php

if (!function_exists('view_loader')) {

    function view_baca1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/baca';
        //$d['pages2'] = viewPathTypeTable($d);
		 $d['pages2'] =viewPathTypeForm($d);
        view_loader2($d);
    }
	function view_detailbaca1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/baca_detail';
        $d['pages2'] = viewPathType1($d);
        view_loader2($d);
    }
    function view_inputnew1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/baca_input';
        $d['pages2'] = viewPathTypeFormAdv($d);
        view_loader2($d);
    }
	function view_input_excel1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'data/baca_input_excel';
        $d['pages2'] = viewPathTypeFormAdv($d);
        view_loader2($d);
    }
}