<?php

if (!function_exists('view_loader')) {

    function view_lap_absensi1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'laporan/lap_absensi';
	//	$d['page_view2'] = 'face/home_data';
	//$CI->_dump();
	//	print_r($d);
        $d['pages2'] = viewPathTypeForm($d);
       // $CI->load->helper('template/'.templateView1($d).'table/bencana');
        view_loader2($d);
    }
	function view_detaillap_absensi1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'laporan/lap_absensi_detail';
        $d['pages2'] = viewPathType1($d);
        view_loader2($d);
    }
    function view_inputnew1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'laporan/lap_absensi_input';
        $d['pages2'] = viewPathTypeForm($d);
        view_loader2($d);
    }
	function print_lap_absensi1($data = '', $output ) {
		$data['page_view'] = 'laporan/lap_absensi_print';
        return viewhelper_lap_absensi1($data, 3, $output);
    }
	 function viewhelper_lap_absensi1($data = '',$plugin, $output=true) {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		// $d['print_page'] =  "L";
		$d['page_view'] = $data['page_view'];
        return view_loader3($d, $output);
    }
	function view_input_excel1($data = '') {
        $CI = &get_instance();
		$d =  $CI->d;
		$d['data'] =  $data;
		$d['page_view'] = 'laporan/lap_absensi_input_excel';
        $d['pages2'] = viewPathTypeFormAdv($d);
        view_loader2($d);
    }
}