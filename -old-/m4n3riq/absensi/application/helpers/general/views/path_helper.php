<?php

if (!function_exists('view_loader')) {

    function templateViewF1($d) {
        $tempview =  $d['data_setting']['template'].'/';
        return $tempview;
    }
    function templateViewF2($d) {
        $tempview = $d['data_setting']['template'].'/general/';
        return $tempview;
    }
    function templateViewRes1($d) {
        $tempview = 'resource/'.$d['template'].'/';
        return $tempview;
    }

    function templateAllpage1($d) {
        $tempview = $d['data_setting']['template'].'/general/';
        return $tempview;
    }
    function templateAllpage2($d) {
        $tempview = 'admin_lte/general/allpage2';
        return $tempview;
    }

    function templatePath() {
        $templatePath = config_item('frontendTemplatePath');
        return $templatePath;
    }

    function viewPathUnit1($views, $d = '', $output = true) {
        $CI = &get_instance();
        $data = $CI->load->view(templateViewF2($d).'part/'.$views, $d, $output);
        return $data;
    }
    function viewPathUnit2($views, $d = '', $output = true) {
        $CI = &get_instance();
        $data = $CI->load->view(templateViewF2($d).'parttype/'.$views, $d, $output);
        return $data;
    }
	function viewPathUnit3($views, $d = '', $output = true) {
        $CI = &get_instance();
        $data = $CI->load->view('-js-/'.$views, $d, $output);
        return $data;
    }
    function viewPathDefault1($d) {
        $data['header'] 		= viewPathUnit1('header1', $d);
        $data['menu'] 			= viewPathUnit1('menu1', $d);
        $data['footer'] 			= viewPathUnit1('footer1', $d);
        return $data;
    }
    function viewPathType1($d) {
        $data['plugin_top'] 		= viewPathUnit2('plugin_top1', $d);
        $data['plugin_bot'] 		= viewPathUnit2('plugin_bot1', $d);
        return $data;
    }
    function viewPathTypeTable($d) {
        $data['plugin_top'] 		= viewPathUnit2('plugin_top2', $d);
        $data['plugin_bot'] 		= viewPathUnit2('plugin_bot2', $d);
        return $data;
    }
	function viewPathTypeForm($d) {
        $data['plugin_top'] 		= viewPathUnit2('plugin_top3', $d);
        $data['plugin_bot'] 		= viewPathUnit2('plugin_bot3', $d);
        return $data;
    }
	function viewPathTypeFormAdv($d) {
        $data['plugin_top'] 		= viewPathUnit2('plugin_top4', $d);
        $data['plugin_bot'] 		= viewPathUnit2('plugin_bot4', $d);
        return $data;
    }
	function viewPathType3($d, $plugin_js1, $plugin_js2="", $plugin_js3="") {
        $data['plugin_top'] 		= viewPathUnit2('plugin_top3', $d);
        $data['plugin_bot'] 		= viewPathUnit2('plugin_bot3', $d);
		$data['plugin_js1'] 		= viewPathUnit3($plugin_js1, $d);
		$data['plugin_js2'] 		='';
		$data['plugin_js3'] 		='';

		if($plugin_js2!=''){
			$data['plugin_js2'] 		= viewPathUnit3($plugin_js2, $d);
		}
		if($plugin_js3!=''){
			$data['plugin_js3'] 		= viewPathUnit3($plugin_js3, $d);
        }
		return $data;
    }

}