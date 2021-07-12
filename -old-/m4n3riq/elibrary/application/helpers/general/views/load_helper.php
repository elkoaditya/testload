<?php

if (!function_exists('view_loader')) {

	function view_loader1admin($d = array(), $output = false) {
        $CI = &get_instance();
		$d['page_temp'] = 'page/login_admin';
        $CI->load->view(templateViewF2($d).$d['page_temp'], $d, $output);
	   return true;
    }
	
    function view_loader1($d = array(), $output = false) {
        $CI = &get_instance();
		$d['page_temp'] = 'page/login';
        $CI->load->view(templateViewF2($d).$d['page_temp'], $d, $output);
	   return true;
    }
		////////TABLE AND GENERAL VIEW/////////////////
    function view_loader2($d = array(), $output = false) {
        $CI = &get_instance();
        $CI->load->helper('template/'.templateViewF1($d).'/dashboard/menu');
		$d['page_temp'] = 'page/allpage1';
		
        $d['pages'] = viewPathDefault1($d);
        $d['page_content'] = $CI->load->view(templateViewF1($d).$d['page_view'], $d, true);
        $CI->load->view(templateViewF2($d).$d['page_temp'], $d, $output);
	   return true;
    }
	
	function view_loader3($d = array(), $output = true) {
        $CI = &get_instance();
		$d['page_temp'] = 'page/allpage3';
		
        $d['page_content'] = $CI->load->view(templateViewF1($d).$d['page_view'], $d, true);
        return $CI->load->view(templateViewF2($d).$d['page_temp'], $d, $output);
		
    }
	

}