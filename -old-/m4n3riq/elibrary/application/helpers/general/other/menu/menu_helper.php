<?php

/**
 * User: Yusuf Fachrudin S
 * Date: 09/08/2015
 * CV. PINASTHIKA NURAGA
 */
if (!function_exists('view_loader')) {

    function menu_home1($d = '',$data = '') {
		
		$menu = "";
		if($d['role'] == "super_admin"){
			$menu = menu_home_super_admin1();
		}elseif($d['role'] == "direktur"){
			$menu = menu_home_direktur1();
		}elseif($d['role'] == "admin"){
			$menu = menu_home_admin1();
		}elseif($d['role'] == "sales"){
			$menu = menu_home_sales1();
		}elseif($d['role'] == "stock"){
			$menu = menu_home_stock1();
		}elseif($d['role'] == "driver"){
			$menu = menu_home_driver1();
		}
		$html = menu_view1($menu, $d['role'], $data);
		
		return $html;
    }
	
}