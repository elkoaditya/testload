<?php

function JamToDetik($jam){
	$temp_jam	= explode(":",$jam);
	$detik		= $temp_jam[0]*60*60;
	$detik		= $detik + $temp_jam[1]*60;
	$detik		= $detik + $temp_jam[2];
	
	return $detik;
}

function JamToMenitMengajar($jam){
	$temp_jam	= explode(":",$jam);
	
	$menit		= $temp_jam[0]*60;
	$menit		= $menit + $temp_jam[1];
	
	// jam 5.30 sore
	if($menit<=330){
		$menit = $menit+720;
	}
	return $menit;
}

function Hari($tanggal){
	
	$day = date('D', strtotime($tanggal));
	$dayList = array(
		'Sun' => 'Minggu',
		'Mon' => 'Senin',
		'Tue' => 'Selasa',
		'Wed' => 'Rabu',
		'Thu' => 'Kamis',
		'Fri' => 'Jumat',
		'Sat' => 'Sabtu'
	);
	
	return $dayList[$day];
}

function cek_siswa_bersangkutan($siswa_id, $data){
	
	$cek = $data;
	if($data==''){
		redirect(base_url().'data/siswa/detail/'.$siswa_id,$verifikasi);
	}else{
		foreach($cek as $value_di=>$key){
			if($key['siswa_id']!=$siswa_id){
				redirect(base_url().'data/siswa/detail/'.$siswa_id,$verifikasi);
			}
		}
	}
}

function chekbox($value){
	$array_chekbox = array(
		"" => 0,
		"on" => 1
	);
	$result  = $array_chekbox[$value];
	
	return $result;
}

function tgltodb($from){
	$tanggal = explode("-", $from );
    $from = $tanggal[2] . "-" . $tanggal[1] . "-" . $tanggal[0];
	
	return $from;
}

function bulan($point=""){
	
	$array = array(
		1	=> "Januari",
		2	=> "Februari",
		3	=> "Maret",
		4	=> "April",
		5	=> "Mei",
		6	=> "Juni",
		7	=> "Juli",
		8	=> "Agustus",
		9	=> "September",
		10	=> "Oktober",
		11	=> "November",
		12	=> "Desember",
	);
	
	if($point=="")
		return $array;
	else{
		$array[0]='';
		return $array[$point];
	}
}

function tgl_resmi($from){
	$tanggal = explode("-", $from );
    $from = $tanggal[0] . " " . bulan((int)$tanggal[1]) . " " . $tanggal[2];
	
	return $from;
}

function a($uri, $label = '', $attributes = '')
{
	$label = (string) $label;

	if (!is_array($uri))
		$site_url = (!preg_match('!^\w+://! i', $uri)) ? base_url($uri) : $uri;
	else
		$site_url = base_url($uri);

	if ($label == '')
		$label = $site_url;

	if ($attributes != '')
		$attributes = _parse_attributes($attributes);

	return '<a href="' . $site_url . '"' . $attributes . '>' . $label . '</a>';

}

// buat link button

function a_button($uri, $icon, $teks, $title = '')
{
	$attr = array(
		'title' => $title,
		'class' => 'ui-state-default ui-corner-all link_button noprint',
		'target' => '_self',
	);
	return a($uri, '<span class="ui-icon ui-icon-' . $icon . '"></span>&nbsp;' . $teks . ' &nbsp; ', $attr);

}

// buat link tombol print

function a_print()
{
	return '<a href="javascript: window.print()" class="ui-state-default ui-corner-all link_button noprint" title="cetek halaman ini ke printer"><span class="ui-icon ui-icon-print"></span>&nbsp;print &nbsp; </a>';

}

// load view addon

function addon($name, $data = array())
{
	$ci = & get_instance();
	$ci->load->view("-addon-/{$name}", $data);

}

// nambah mesej bos

function alert_dump($message, $label = '')
{
	$ci = & get_instance();
	$ci->d['alert']['info'][] = '<pre>' . $label . ' : ' . print_r($message, TRUE) . '</pre>';

	return TRUE;

}

// nambah alert & set status error

function alert_error($message, $error = TRUE)
{
	$ci = & get_instance();
	$ci->d['alert']['error'][] = $message;

	if ($error)
		$ci->d['error'] = TRUE;

	if ($error === '')
		return $ci->_redir();

	if (is_string($error))
		return redir($error);

	return NULL;

}

// pesan error & info

function alert_get($div_attr = '', $alert_attr = '', $success_attr = '', $info_attr = '')
{
	$ci = & get_instance();
	
	if(isset($ci->d['alert'])){
		if (!$ci->d['alert']['error'] && !$ci->d['alert']['success'] && !$ci->d['alert']['info'])
			return NULL;
	}
	
	if(!isset($ci->d['alert']))
		$ci->d['alert'] =	$ci->session->flashdata('alert');
	
	if ($alert_attr === '')
		$alert_attr = 'class="alert alert-danger"';

	if ($success_attr === '')
		$success_attr = 'class="alert alert-success"';

	if ($info_attr === '')
		$info_attr = 'class="alert alert-info"';

	$dat = div($div_attr);

	if(isset($ci->d['alert']['error'] )){
		if ($alert_attr !== FALSE)
			foreach ($ci->d['alert']['error'] as $msg)
				if ($msg)
					$dat .= div($alert_attr, $msg);
	}if(isset($ci->d['alert']['success'] )){
		if ($success_attr !== FALSE)
			foreach ($ci->d['alert']['success'] as $msg)
				if ($msg)
					$dat .= div($success_attr, $msg);
	}if(isset($ci->d['alert']['info'] )){
		if ($info_attr !== FALSE)
			foreach ($ci->d['alert']['info'] as $msg)
				if ($msg)
					$dat .= div($info_attr, $msg);
	}
	return $dat . '</div>';

}

// nambah mesej bos

function alert_info($message, $redir = FALSE)
{
	$ci = & get_instance();
	$ci->d['alert']['info'][] = $message;

	if ($redir === '')
		return $ci->_redir();

	if ($redir !== FALSE)
		return redir($redir);

	return TRUE;

}

// nambah mesej bos

function alert_success($message, $redir = FALSE)
{
	$ci = & get_instance();
	$ci->d['alert']['success'][] = $message;

	if ($redir === '')
		return $ci->_redir();

	if ($redir !== FALSE)
		return redir($redir);

	return TRUE;

}


// membuat hash
/* /
  function crypto($string, $key = APP_NAME) {
  $c1 = md5(crc32($key . $string));
  $c2 = md5($key . $string);
  $c3 = sha1($key . $string);
  $code = base64_encode("{$c1}{$c2}{$c3}");

  if (strlen($code) > 100)
  $code = substr($code, 10, 100);

  return $code;
  }
  // */
function crypto($string, $key = 'fresto6')
{

	return md5($string . $key) . md5($string);

}


// convert date ke tgl

function date2tgl($tanggal, $format = 'd-m-Y')
{
	$tanggal = (string) $tanggal;

	if ($tanggal == '' OR $tanggal == '0000-00-00')
		return NULL;

	$dto = date_create($tanggal);

	if ($dto === FALSE)
		return NULL;

	return $dto->format($format);

}


// buat tag div

function div($attr = '', $inner = '')
{
	return tag('div', $attr, $inner);

}

// exit & dumping

function dump($var, $label = '')
{
	echo('<pre>' . $label . ': ' . print_r($var, TRUE) . '</pre>');

}

// exit & dumping

function exit_dump($var)
{
	exit('<pre>' . print_r($var, TRUE) . '</pre>');

}

// simpan data flash

function flash_msg()
{
	$ci = & get_instance();
	$alert = (array) $ci->session->flashdata('alert');
	$alert = array_merge($alert, $ci->d['alert']);
	$ci->d['alert'] = array();
	$ci->session->set_flashdata('alert', $alert);

}

// file ada

function file_ada($path)
{
	try
	{
		return @file_exists($path);
	}
	catch (Exception $e)
	{
		return FALSE;
	}

}

// menampilkan foto

function img_foto($full_path, $attr = array())
{
	$full_path = path_relative($full_path);
	$attr['src'] = base_url('content/no-photo.jpg');

	if (!empty($full_path) && file_exists($full_path))
		$attr['src'] = base_url($full_path);

	return a($attr['src'], img($attr), 'title="lihat gambar lebih besar" target="_blank"');

}

// menampilkan image

function image($full_path, $noimg = '<i>image tidak ditemukan.</i>', $attr = array())
{

	if (empty($full_path) OR ! file_exists($full_path))
		return $noimg;

	$attr['src'] = webpath($full_path);

	return img($attr);

}


// redirect ke alamat tertentu

function redir($uri = '')
{
	flash_msg();

	if (!preg_match('#^https?://#i', $uri))
		$uri = base_url($uri);

	header("Location: " . $uri, TRUE, 302);

	exit();

}


// convert tgl ke date

function tgl2date($tanggal, $delimeter = '-')
{
	$tanggal = (string) $tanggal;

	if ($tanggal == '')
		return NULL;

	$a_tgl = explode($delimeter, $tanggal);

	if (!checkdate((int) $a_tgl[1], (int) $a_tgl[0], (int) $a_tgl[2]))
		return NULL;

	$dto = date_create("{$a_tgl[2]}-{$a_tgl[1]}-{$a_tgl[0]}");
	return $dto->format('Y-m-d');

}

// convert datetime ke string & jam

function tglwaktu($tanggal)
{
	$tanggal = (string) $tanggal;

	if (!$tanggal OR $tanggal == '0000-00-00' OR $tanggal == '0000-00-00 00:00:00')
		return NULL;

	$a_hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
	$a_bulan = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des');

	$date = date_create($tanggal);

	$i_bln = date_format($date, 'n');
	$i_hr = date_format($date, 'w');
	$hari = $a_hari[$i_hr];
	$bulan = $a_bulan[$i_bln];
	$tgl = date_format($date, 'j');
	$tahun = date_format($date, 'Y');
	$waktu = date_format($date, 'H:i');

	return "{$hari}, {$tgl} {$bulan} {$tahun} jam {$waktu}";

}

// convert date ke string

function tgl($tanggal, $rinkas_tahun = FALSE)
{
	$tanggal = (string) $tanggal;

	if (!$tanggal OR $tanggal == '0000-00-00' OR $tanggal == '0000-00-00 00:00:00')
		return NULL;

	$a_hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
	$a_bulan = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des');

	$dt = date_create($tanggal);

	if (!$dt)
		return NULL;

	$i_hr = (int) date_format($dt, 'w');
	$i_bln = (int) date_format($dt, 'n');

	$hari = $a_hari[$i_hr];
	$bulan = $a_bulan[$i_bln];

	$tgl = date_format($dt, 'j');
	$tahun = date_format($dt, 'Y');

	if ($rinkas_tahun && $tahun == date('Y'))
		$tahun = '';

	return trim("{$hari}, {$tgl} {$bulan} {$tahun}");

}
function breacrumbs($list, $attr = 'class="breadcrumb"')
{
	$dat = '<div>' . tag('ul', $attr);

	foreach ($list as $idx => $val):
		if (is_integer($idx))
			$dat .=li('class="active"', $val);
		else
			$dat .= li('', a($val, $idx) . ' <span class="divider">/</span>');
	endforeach;

	return $dat . '</ul></div>';

}

function pills($list, $attr = 'class="nav nav-pills"')
{
	if (!$list)
		return;

	$dat = '<div>' . tag('ul', $attr);
	$def = array('uri' => '', 'label' => '', 'attr' => '', 'class' => '');

	foreach ($list as $item):
		array_default($item, $def);

		if ($item['class'] == 'disabled')
			$a = "<a href=\"#\" {$item['attr']}>{$item['label']}</a>";
		else if (strpos($item['uri'], '#') !== FALSE)
			$a = "<a href=\"{$item['uri']}\" {$item['attr']}>{$item['label']}</a>";
		else
			$a = a($item['uri'], $item['label'], $item['attr']);

		$dat .= li("class=\"{$item['class']}\"", $a);

	endforeach;

	return $dat . '</ul></div>';

}

// generate tag

function tag($tag, $attr = '', $inner = '')
{

	$tmp = "<{$tag} ";

	if (is_array($attr))
		foreach ($attr as $prop => $val):
			if (is_array($val))
				$val = implode(' ', $val);

			$tmp .= "{$prop}=\"{$val}\" ";

		endforeach;
	else
		$tmp .= $attr;

	if ($inner === '')
		$tmp .= '>';
	else if ($inner === FALSE)
		$tmp .= '/>';
	else
		$tmp .= ">{$inner}</{$tag}>";

	return $tmp;

}
function cek_exist($filename="")
{
	if (file_exists($filename)) {
		return 1;
	} else {
		return 0;
	}

}

///////////TXT Khusus///////////////
function txtfiles($file="")
{
	$set_return = "coba cari filenya";
	if($file !=""){
		$set_return = "Tidak dapat membuka file!";
		$myfile = fopen($file.'.html', "r") or die($set_return);
		
		$set_return =  fgets($myfile);
		fclose($myfile);
	}
	return $set_return;

}

function txtfiles_explode($file="")
{
	$set_return = "coba cari filenya";
	if($file !=""){
		$set_return = "Tidak dapat membuka file!";
		$myfile = fopen($file.'.txt', "r") or die($set_return);
		
		$set_return =  fgets($myfile);
		fclose($myfile);
		/*
		$exp1 = explode(',',$set_return);
		foreach ($exp1 as $key => $value){
			
		}
		*/
	}
	return $set_return;

}


function txtfiles_addtext($file="",$add_text="")
{
	$set_return = "terjadi kesalahan";
	if(($file !="")&&($add_text !="")){
		
		$handle = fopen($file.'.txt', 'r') or die('Cannot open file:  '.$file);
		$data = 'This is the data';
		fwrite($handle, $data);
		
		fclose($handle);
		
		
	}
	return $set_return;
}

function txtfiles_overwrite($file="",$text="")
{
	$set_return = "terjadi kesalahan";
	if(($file !="")&&($text !="")){
		$set_return = "Tidak dapat membuka file!";
		$myfile = fopen($file.'.txt', "r") or die($set_return);
		
		fwrite($myfile, $text);
		fclose($myfile);
	}
	return $set_return;
}


function cek_last_id_txt($data,$split)
{
	$explode1 = explode($split['set_split'][0],$data);
	$count = count($explode1);
	$sc = $count -1 ;
	$explode2 = explode($split['set_split'][1],$explode1[$sc]);
	return $explode2[1];
}
function txt_cek_split_title($data,$split)
{
	$explode1 = explode($split['set_split'][0],$data);
	$count = count($explode1);
	//$sc = $count -1 ;
	$explode2 = explode($split['set_split'][1],$explode1[0]);
	return $explode2;
}
function txt_cek_split_data($data)
{
	$explode1 = explode($data['set_split'][0],$data['data_bencana']);
	$count = count($explode1);
	//$sc = $count -1 ;
	for ($a = 0; $a < $count; $a++) {
		$explode2[$a] = explode($data['set_split'][1],$explode1[$a]);
	}
	return $explode2;
}

function replace_word1($word,$data)
{
	$setreturn = '-';
	if($word == ''){
		return $setreturn;
	}
	for ($a = 0; $a < count($data['set_split']); $a++) {
	
		if($word == $data['set_split'][$a]){
			return $setreturn;
		}
		
	}
	return $word;
}
///////dari sini///////////
/////////////////////////
////////excel////////
//////////////////////
function excel_data($d,$Nsheet = 0){
	//$data = array();
	$objPHPExcel = 0;
			$inputFileName = $d;
		//  Read your Excel workbook
		try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
		} catch (Exception $e) {
			die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
			. '": ' . $e->getMessage());
		}
	$sheet = $objPHPExcel->getSheet($Nsheet);
	$highestRow = $sheet->getHighestRow();
	$highestColumn = $sheet->getHighestColumn();
		
	$rowData = $sheet->rangeToArray('A1:'.$highestColumn.$highestRow, NULL, TRUE, FALSE);
	return $rowData;
}
function get_excel_data($d,$Nsheet = 0){
	$gets = excel_data($d,$Nsheet);
	$data['head'] = get_title_excel($gets);
	$data['data']= get_data_excel($gets,$data);
	return $data;
}

function get_excel_alldata($d,$Nsheet = 0){
	$gets = excel_data($d,$Nsheet);
	$data['head'] = get_title_excel($gets);
	$data['data']= get_data_excel($gets,$data);
	return $data;
}
function get_title_excel($d){
	$a = 0;
	$c = 0;
	foreach ($d as $value => $key) {
		$a++;
		$b = 0;
		//$data[$a][$value] = $value;
		
		foreach ($key as $value2 => $key2) {
			$b++;
			if($b > 10){
				if($key2 != ""){
					if($a == 10){
						$c++;
						$data[$c] = $key2;
					}
				}
			}
		}
		
	}
	 return $data;
}
function get_data_excel($d,$e){
	$data = array();
	$row = 0;
	$Rowlimit = 10;
	$Collimit = 10;
	foreach ($d as $value => $key) {
		$row++;
		$col_no = 0;
		//$data[$z][$value] = $value;
		
		$col = 0;
		foreach ($key as $value2 => $key2) {
			$col_no++;
			if($col_no > $Collimit){
					if($row > $Rowlimit){
						$col++;
						$no = $row - $Rowlimit;
						$data[$no][$e['head'][$col]] = $key2;
					}
				
			}
		}
		
	}
	 return $data;
}
function excel_import($d){
	
	$target_dir = 'uploads/';
	$target_file = $target_dir . basename($_FILES["filepath"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	move_uploaded_file($_FILES["filepath"]["tmp_name"], $target_file);
	
	
	//$target_dir = 'uploads/';
	//$target_file = $d['path'] . basename($d['file']);
	//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	//move_uploaded_file($d['rename_file'], $target_file);
	echo "ddddddddd";
}

function save_excel($d)
{
		
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Yusuf FS")
								 ->setLastModifiedBy("Yusuf FS")
								 ->setTitle("AKUNTANSI")
								 ->setSubject("AKUNTANSI SOFTWARE")
								 ->setDescription("FRESTO")
								 ->setKeywords("FRESTO SOFTWARE")
								 ->setCategory("Test result file");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Hello')
				->setCellValue('B2', 'world!')
				->setCellValue('C1', 'Hello')
				->setCellValue('D2', 'world!');

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('LAPORAN');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Save Excel 2007 file
	$callStartTime = microtime(true);

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save($d['filename']);
	/*
	echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
	echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;

	// Echo memory usage
	echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;
	*/
	//return true;
}



//////cek file in folder////
function edit_excel($d)
{
		$d['filename'] = 'edit-an-excel-file-using-phpexcel.xlsx';

		/*check point*/

		// Read the existing excel file
		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);

		// Update it's data
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Add column headers
		$objPHPExcel->getActiveSheet()
					->setCellValue('A1', 'EDITED Last Name')
					->setCellValue('B1', 'EDITED First Name')
					->setCellValue('C1', 'EDITED Age')
					->setCellValue('D1', 'EDITED Sex')
					->setCellValue('E1', 'EDITED Location')
					;
					
		// Generate an updated excel file
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $inputFileName . '"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
}
///////////////////////////
//////////adds common/////

function tgl_explode_sort($d,$explode=" ")
{
	$b = array(
		1 => "januari",
		2 => "febuari",
		3 => "maret",
		4 => "april",
		5 => "mei",
		6 => "juni",
		7 => "juli",
		8 => "agustus",
		9 => "september",
		10 => "oktober",
		11 => "november",
		12 => "desember",
		);
	/////$d = tgl bln thn
	$data = explode($explode,$d);
	$tgl = $data[0];
	$bln = strtolower($data[1]);
	$thn = $data[2];
	
	for ($i = 1; $i <= 12; $i++) {
		if($b[$i] == $bln){
			if($i < 10){
				$bln = "0".$i;
			}else{
				$bln = $i;
			}
		}
	}
	$set_return = $thn.$bln.$tgl;
	return $set_return;
}
function buatrp_new($angka)
{
	$jadi = "Rp " . number_format($angka,2,',','.');
	return $jadi;
}
function buatrp_new2($angka)
{
	$jadi = number_format($angka,2,',','.');
	return $jadi;
}
function buat_kode($kode, $digit)
{
	return $kode.sprintf('%05d',$digit);
}
///////////template sementara/////////////

function order_step_ket($data)
{
	//if($data['step_actif'])
	for ($i = 1; $i <= 5; $i++) {
		$step_ket = 'error';
		if($data['step_actif'] > $i){
			$step_ket = "done";
		}
		if($data['step_actif'] == $i){
			$step_ket = "active";
		}
		$step_actif[$i] = $step_ket;
	}
	$asdasd = '
		<div class="portlet-body">
            <div class="mt-element-step">
                <div class="row step-line">
                    <div class="col-md-3 mt-step-col first '.$step_actif[1].'">
                        <div class="mt-step-number bg-white">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="mt-step-title uppercase font-grey-cascade">Faktur</div>
                        <div class="mt-step-content font-grey-cascade">Buat Faktur</div>
                    </div>
                    <div class="col-md-3 mt-step-col '.$step_actif[2].'">
                        <div class="mt-step-number bg-white">
                            <i class="fa fa-cc-visa"></i>
                        </div>
                        <div class="mt-step-title uppercase font-grey-cascade">Order </div>
                        <div class="mt-step-content font-grey-cascade">Order Barang</div>
                    </div>
                    <div class="col-md-3 mt-step-col '.$step_actif[3].'">
                        <div class="mt-step-number bg-white">
                            <i class="fa fa-rocket"></i>
                        </div>
                        <div class="mt-step-title uppercase font-grey-cascade">Pembayaran</div>
                        <div class="mt-step-content font-grey-cascade">Pembayaran</div>
                    </div>
                    <div class="col-md-3 mt-step-col last '.$step_actif[4].'">
                        <div class="mt-step-number bg-white">
                            <i class="fa fa-rocket"></i>
                        </div>
                        <div class="mt-step-title uppercase font-grey-cascade">Status</div>
                        <div class="mt-step-content font-grey-cascade">Lunas</div>
                    </div>
                </div>
            </div>
        </div>
	';
	return $asdasd;
}

function integerToRoman($integer)
{
	 // Convert the integer into an integer (just to make sure)
	 $integer = intval($integer);
	 $result = '';
	 
	 // Create a lookup array that contains all of the Roman numerals.
	 $lookup = array('M' => 1000,
	 'CM' => 900,
	 'D' => 500,
	 'CD' => 400,
	 'C' => 100,
	 'XC' => 90,
	 'L' => 50,
	 'XL' => 40,
	 'X' => 10,
	 'IX' => 9,
	 'V' => 5,
	 'IV' => 4,
	 'I' => 1);
	 
	 foreach($lookup as $roman => $value){
	  // Determine the number of matches
	  $matches = intval($integer/$value);
	 
	  // Add the same number of characters to the string
	  $result .= str_repeat($roman,$matches);
	 
	  // Set the integer to be the remainder of the integer and the value
	  $integer = $integer % $value;
	 }
	 
	 // The Roman numeral should be built, return it
	 return $result;
}

function jenisKelamin($kelamin){
	$array = array("" => "", "L" => "Laki-laki","P" => "Perempuan");
	
	return $array[$kelamin];
}

function Terbilang($x)
{
	$x = (int)$x;
	
	$ambil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	if ($x < 12)
		return " " . $ambil[$x];
	elseif ($x < 20)
		return Terbilang($x - 10) . " belas";
	elseif ($x < 100)
		return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
	elseif ($x < 200)
		return " seratus" . Terbilang($x - 100);
	elseif ($x < 1000)
		return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
	elseif ($x < 2000)
		return " seribu" . Terbilang($x - 1000);
	elseif ($x < 1000000)
		return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
	elseif ($x < 1000000000)
		return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
}



function terbilang_koma($x){
	if($x<0){
		$hasil = "minus ".trim(Terbilang(x));
	}else{
		$poin = '';
		$str = stristr($x,",");
		$ex = explode(',',$x);
		$str = stristr($x,".");
		$ex = explode('.',$x);
		
		$hasil = trim(Terbilang($ex[0]));
		if(isset($ex[1])){
			$poin = trim(Terbilang($ex[1]));
		}
		
	}

	if($poin){
		$hasil = $hasil." koma ".$poin;
	}else{
		$hasil = $hasil;
	}
	return $hasil;  
}


