<?php

/**
 * User: Yusuf Fachrudin S
 * Date: 09/08/2015
 * CV. PINASTHIKA NURAGA
 */
if (!function_exists('view_loader')) {

   
	
	function menu_home_super_admin1($data = '') {
		$html = array(
			'input_barang' => array(
				'menu_nama'			=> 'Master Barang',
				'menu_icon' 		=> 'fa fa-cube',
				'menu_color'		=> 'purple-seance',
				'menu_url'			=> 'dashboard/home',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Barang',
				'menu_desc_last'	=> '',
			),
				
			'input_satuan' => array(
				'menu_nama'			=> 'Master Satuan',
				'menu_icon' 		=> 'fa fa-tag',
				'menu_color'		=> 'blue',
				'menu_url'			=> 'data/item',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Satuan',
				'menu_desc_last'	=> '',
			),
			
			'input_costumer' => array(
				'menu_nama'			=> 'Master Pelanggan',
				'menu_icon' 		=> 'fa fa-user',
				'menu_color'		=> 'red-thunderbird',
				'menu_url'			=> 'data/pelanggan',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Pelanggan',
				'menu_desc_last'	=> '',
			),
			
			'input_stok' => array(
				'menu_nama'			=> 'Stock',
				'menu_icon' 		=> 'fa fa-money',
				'menu_color'		=> 'blue-hoki',
				'menu_url'			=> 'data/stok',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Stock',
				'menu_desc_last'	=> '',
			),
			
			'input_harga' => array(
				'menu_nama'			=> 'Harga',
				'menu_icon' 		=> 'fa fa-dollar',
				'menu_color'		=> 'green-meadow',
				'menu_url'			=> 'data/harga',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Harga',
				'menu_desc_last'	=> '',
			),
			
			'input_nota' => array(
				'menu_nama'			=> 'Nota',
				'menu_icon' 		=> 'fa fa-edit',
				'menu_color'		=> 'yellow-crusta',
				'menu_url'			=> 'transaksi/nota',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Nota',
				'menu_desc_last'	=> '',
			),
			
			'input_bayar' => array(
				'menu_nama'			=> 'Bayar',
				'menu_icon' 		=> 'fa fa-credit-card',
				'menu_color'		=> 'yellow-gold',
				'menu_url'			=> 'transaksi/bayar',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Bayar',
				'menu_desc_last'	=> '',
			),
			
			'lap_penjualan' => array(
				'menu_nama'			=> 'Lap.Penjualan',
				'menu_icon' 		=> 'fa fa-bar-chart',
				'menu_color'		=> 'purple-sharp',
				'menu_url'			=> 'laporan/penjualan',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Penjualan',
				'menu_desc_last'	=> '',
			),
			
			'lap_profit' => array(
				'menu_nama'			=> 'Lap.Laba Rugi',
				'menu_icon' 		=> 'fa fa-line-chart',
				'menu_color'		=> 'red-haze',
				'menu_url'			=> 'laporan/laba_rugi',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Profit',
				'menu_desc_last'	=> '',
			),
		);
	
      	
		return $html;
    }
	function menu_home_admin1($data = '') {
      	$html = array(
			'input_barang' => array(
				'menu_nama'			=> 'Master Barang',
				'menu_icon' 		=> 'fa fa-cube',
				'menu_color'		=> 'purple-seance',
				'menu_url'			=> 'dashboard/home',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Barang',
				'menu_desc_last'	=> '',
			),
				
			'input_satuan' => array(
				'menu_nama'			=> 'Master Satuan',
				'menu_icon' 		=> 'fa fa-tag',
				'menu_color'		=> 'blue',
				'menu_url'			=> 'data/item',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Satuan',
				'menu_desc_last'	=> '',
			),
			
			'input_costumer' => array(
				'menu_nama'			=> 'Master Pelanggan',
				'menu_icon' 		=> 'fa fa-user',
				'menu_color'		=> 'red-thunderbird',
				'menu_url'			=> 'data/pelanggan',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Pelanggan',
				'menu_desc_last'	=> '',
			),
			
			'input_stok' => array(
				'menu_nama'			=> 'Stock',
				'menu_icon' 		=> 'fa fa-money',
				'menu_color'		=> 'blue-hoki',
				'menu_url'			=> 'data/stok',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Stock',
				'menu_desc_last'	=> '',
			),
			
			'input_harga' => array(
				'menu_nama'			=> 'Harga',
				'menu_icon' 		=> 'fa fa-dollar',
				'menu_color'		=> 'green-meadow',
				'menu_url'			=> 'data/harga',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Harga',
				'menu_desc_last'	=> '',
			),
			
			'input_nota' => array(
				'menu_nama'			=> 'Nota',
				'menu_icon' 		=> 'fa fa-edit',
				'menu_color'		=> 'yellow-crusta',
				'menu_url'			=> 'transaksi/nota',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Nota',
				'menu_desc_last'	=> '',
			),
			
			'input_bayar' => array(
				'menu_nama'			=> 'Bayar',
				'menu_icon' 		=> 'fa fa-credit-card',
				'menu_color'		=> 'yellow-gold',
				'menu_url'			=> 'transaksi/bayar',
				'menu_value_number'	=> '',
				'menu_desc_first'	=> 'Bayar',
				'menu_desc_last'	=> '',
			),
		);
	
      	
		return $html;
    }
	
	function menu_view1($menu = '', $role = '', $data) {
		
		$html = "";
      	if($menu != ""){
			
			if($role == "super_admin")
			{
			$html .= '
				<div class="row">
						
					<div class="col-md-12">
						<div class="portlet light portlet-fit bordered">
							<div class="portlet-title">
								<div class="caption">
									<i class=" icon-layers font-green"></i>
									<span class="caption-subject font-green bold uppercase">GRAFIK LABA - RUGI / BULAN</span>
								</div>
								
						
								<div class="actions">
									
									<a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
								
								</div>
							</div>
							<div class="portlet-body">
								<div class="row">
									
								</div>
								<div id="highchart_profit" style="height:400px;"></div>
							</div>
						</div>
					</div>
				
				</div>
				<div class="row">				
					<div class="col-md-12">
						<div class="portlet light portlet-fit bordered">
							<div class="portlet-title">
								<div class="caption">
									<i class=" icon-layers font-green"></i>
									<span class="caption-subject font-green bold uppercase">GRAFIK OMZET BARANG TERBESAR</span>
								</div>
								
						
								<div class="actions">
									
									<a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
								
								</div>
							</div>
							<div class="portlet-body">
								<div class="row">
									
								</div>';
								
				if(isset($data['omzet_item_terlaris']['data'])){ 
					$html .= '	<div  id="h_omzet_barang_terlaris" style="height:500px;"></div>';
				}else{ 
					$html .= '	<div class="alert alert-danger"><strong>Data Kosong</strong></div>';
				} 
				
				$html .= '	</div>
						</div>
					</div>
				</div>
				
				<div class="row">	
					<div class="col-md-12">
						<div class="portlet light portlet-fit bordered">
							<div class="portlet-title">
								<div class="caption">
									<i class=" icon-layers font-green"></i>
									<span class="caption-subject font-green bold uppercase">Grafik Jumlah Barang Terlaris</span>
								</div>
								
						
								<div class="actions">
									
									<a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
								
								</div>
							</div>
							<div class="portlet-body">'; 
					if(isset($data['jumlah_item_terlaris']['data'])){ 
							$html .= '	<div  id="h_jumlah_barang_terlaris" style="height:500px;"></div>';
					}else{ 
						$html .= '	<div class="alert alert-danger"><strong>Data Kosong</strong></div>';
					} 
								
							$html .= '	
							</div>
						</div>
					</div>
					
				</div>';
			}
			
			$html .= '<div class="row">';
			
				foreach($menu as $value)
				{
					
			$html .= '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
			$html .= '	<a href="'.base_url().$value["menu_url"].'">';
			$html .= '				<div class="dashboard-stat '.$value["menu_color"].' ">';
			$html .= '					<div class="visual">';
			$html .= '						<i class="'.$value["menu_icon"].'"></i>';
			$html .= '					</div>';
			$html .= '					<div class="details">';
			$html .= '						<div class="number">'.$value["menu_desc_first"].'';
			//$html .= '							<span data-counter="counterup" data-value="'.$value["menu_value_number"].'"> 0</span> ';
			//$html .= 							$value["menu_desc_last"];
			$html .= '						</div>';
			$html .= '						<div class="desc"> '.$value["menu_nama"].' </div>';
			$html .= '					</div>';
			$html .= '					<div class="more" > View more';
			$html .= '						<i class="m-icon-swapright m-icon-white"></i>';
			$html .= '					</div>';
			$html .= '				</div>';
			$html .= '			</a>';
			$html .= '		</div>';
					
				}
			$html .= '</div>';
		}
		return $html;
    }
}