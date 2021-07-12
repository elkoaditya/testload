<?php

// buat link anchor

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
		'title'	 => $title,
		'class'	 => 'ui-state-default ui-corner-all link_button noprint',
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

	if (!$ci->d['alert']['error'] && !$ci->d['alert']['success'] && !$ci->d['alert']['info'])
		return NULL;

	if ($alert_attr === '')
	{	
		$alert_attr = 'class="alert alert-error"';
		if(THEME=='material_admin')
			$alert_attr = 'id="alert" class="alert alert-danger"';
	}
	
	if ($success_attr === '')
	{
		$success_attr = 'class="alert alert-success"';
		if(THEME=='material_admin')
			$success_attr = 'id="alert" class="alert alert-success"';
	}
	
	if ($info_attr === '')
	{
		$info_attr = 'class="alert alert-info"';
		if(THEME=='material_admin')
			$info_attr = 'id="alert" class="alert alert-info"';
	}

	$dat = div($div_attr);

	if ($alert_attr !== FALSE)
		foreach ($ci->d['alert']['error'] as $msg)
			if ($msg)
				$dat .= div($alert_attr, $msg);

	if ($success_attr !== FALSE)
		foreach ($ci->d['alert']['success'] as $msg)
			if ($msg)
				$dat .= div($success_attr, $msg);

	if ($info_attr !== FALSE)
		foreach ($ci->d['alert']['info'] as $msg)
			if ($msg)
				$dat .= div($info_attr, $msg);

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

// membuat link dgn title pendek walau address panjang

function anz($address, $limit = 20)
{
	return a(prep_url($address), chr_limiter($address, $limit, FALSE), 'title="' . $address . '" target="_blank"');

}

// mengubah tipe string jadi integer dlm array otomatis

function array_autoint(&$var)
{
	foreach ($var as $key => $val)
		$var[$key] = intif($val);

}

// mengisi array dgn nilai default

function array_default(&$array, $defaults)
{
	$array = (array) $array;
	$defaults = (array) $defaults;

	foreach ($defaults as $key => $value):
		if (!isset($array[$key]))
			$array[$key] = $value;

		else if (is_array($array[$key]) && is_array($value))
			array_default($array[$key], $value);

	endforeach;

}

// membuat hash dr susunan array

function array_hash()
{
	$data = func_get_args();
	$data = json_encode($data);
	return md5($data);

}

// mengubah tipe string jadi integer dlm array

function array_int(&$var, $param)
{
	$param = (array) $param;

	foreach ($param as $key)
		if (array_key_exists($key, $var))
			$var[$key] = as_int($var[$key]);

}

// ubah key tertentu dari json ke array

function array_jdec(&$var, $param = '2be array')
{
	$param = (array) $param;

	foreach ($param as $key)
		if (array_key_exists($key, $var))
			$var[$key] = (array) json_decode($var[$key], TRUE);

}

// ubah key tertentu dr array ke json automatik

function array_jencauto(&$var)
{
	foreach (array_keys($var) as $key)
		if (is_array($var[$key]))
			$var[$key] = (string) json_encode($var[$key]);

}

// ubah key tertentu dr array ke json

function array_jenc(&$var, $param = '2be string')
{
	$param = (array) $param;

	foreach ($param as $key)
		if (array_key_exists($key, $var))
			$var[$key] = (string) json_encode($var[$key]);

}

// mengambil node tertentu dr array

function array_node($data, $path)
{

	if (empty($data))
		return NULL;

	$data = (array) $data;
	$path = (array) $path;
	$num_args = func_num_args();

	if ($num_args > 2)
		for ($_i = 2; $_i < $num_args; $_i++)
			$path[] = func_get_arg($_i);

	foreach ($path as $key):

		$data = (is_array($data) && isset($data[$key]) ) ? $data[$key] : NULL;

		if (is_null($data))
			break;

	endforeach;

	return $data;

}

// array node dgn nilai default

function array_nodex($data, $path, $default = NULL)
{
	$val = array_node($data, $path);

	return (!is_null($val)) ? $val : $default;

}

// generate get querystring dr array

function array2qs($array = '')
{
	$ci = & get_instance();

	if ($array === '')
		$array = $ci->d['request'];

	$str = array();
	$array = (array) $array;
	$array = array_filter($array);

	if (count($array) == 0)
		return NULL;

	foreach ($array as $key => $value)
		if (!is_array($value))
			$str[] = "{$key}={$value}";
		else
			foreach ($value as $i => $subvalue)
				$str[] = "{$key}[{$i}]={$subvalue}";

	if (count($str) == 0)
		return NULL;

	return "?" . implode("&", $str);

}

// convert ke bool

function as_bool($str)
{
	return ($str && $str !== '0') ? 1 : 0;

}

// convert ke integer/absolute

function as_int($str)
{
	return abs($str);

}

// convert ke string

function as_string($str)
{
	return trim((string) $str);

}

// rata2

function avg($array)
{
	return array_sum($array) / count($array);

}

// ambil konfig di controller

function cfgc()
{
	$ci = & get_instance();
	$args = func_get_args();
	$uri = $ci->d['uri'];

	if ($uri != '' && isset($ci->cfg[$uri]))
		array_unshift($args, $uri);

	return array_node($ci->cfg, $args);

}

// ambil config user

function cfgu()
{
	$ci = & get_instance();
	$args = func_get_args();

	return array_node($ci->d['user'], $args);

}

// ambil config user akses sbg admin

function cfguc()
{
	$ci = & get_instance();
	$args = func_get_args();

	return array_node($ci->d['user']['config'], $args);

}

// ambil config user akses sbg admin

function cfguc_admin()
{
	$ci = & get_instance();

	if (!isset($ci->d['user']['config']) OR $ci->d['user']['id'] == 0)
		return FALSE;

	$ak = (string) array_node($ci->d['user']['config'], func_get_args());
	return ($ak === 'admin');

}

// ambil config user akses sbg admin

function cfguc_view()
{
	$ci = & get_instance();

	if (!isset($ci->d['user']['config']) OR $ci->d['user']['id'] == 0)
		return FALSE;

	$ak = (string) array_node($ci->d['user']['config'], func_get_args());

	return in_array($ak, array('admin', 'view'));

}

// membatasi jml karakter

function chr_limiter($string, $limit = 20, $wrap = TRUE)
{
	$string = (string) $string;

	if (strlen($string) > $limit)
		$txt = substr($string, 0, $limit) . '&hellip;';
	else
		$txt = $string;

	return ($wrap) ? '<span title="' . $string . '">' . $txt . '</span>' : $txt;

}

// bersihkan string dr karakter html

function clean($str)
{

	if (empty($str))
		return '';

	$str = (string) $str;
	$str = (string) strip_tags($str);
	$str = (string) htmlentities($str, ENT_QUOTES);
	$str = (string) clean_spaces($str);
	$str = (string) clean_charset($str);

	return $str;

}

// membersihkan karakter aneh2 diluar utf-8

function clean_charset($text)
{
	$regex = <<<'END'
/
  (
    (?: [\x00-\x7F]               # single-byte sequences   0xxxxxxx
    |   [\xC0-\xDF][\x80-\xBF]    # double-byte sequences   110xxxxx 10xxxxxx
    |   [\xE0-\xEF][\x80-\xBF]{2} # triple-byte sequences   1110xxxx 10xxxxxx * 2
    |   [\xF0-\xF7][\x80-\xBF]{3} # quadruple-byte sequence 11110xxx 10xxxxxx * 3
    ){1,100}                      # ...one or more times
  )
| ( [\x80-\xBF] )                 # invalid byte in range 10000000 - 10111111
| ( [\xC0-\xFF] )                 # invalid byte in range 11000000 - 11111111
/x
END;

	return preg_replace_callback($regex, "clean_charset_utf8replacer", $text);

}

function clean_charset_utf8replacer($captures)
{
	if ($captures[1] != "")
	{
		// Valid byte sequence. Return unmodified.
		return $captures[1];
	}
	elseif ($captures[2] != "")
	{
		// Invalid byte of the form 10xxxxxx.
		// Encode as 11000010 10xxxxxx.
		return "\xC2" . $captures[2];
	}
	else
	{
		// Invalid byte of the form 11xxxxxx.
		// Encode as 11000011 10xxxxxx.
		return "\xC3" . chr(ord($captures[3]) - 64);
	}

}

function clean_excel_value($str, $chr = " ,.'")
{
	$str = (string) trim($str, $chr);
	$str = clean($str);

	return $str;

}

// bersihkan teks html

function clean_html($str)
{
	$str = (string) clean_js($str);
	$str = (string) clean_spaces($str);
	$str = (string) clean_charset($str);

	return $str;

}

// bersihkan teks dr java skrip

function clean_js($str)
{
	$str = (string) $str;
	$str = (string) preg_replace('#<script(.*?)>(.*?)</script>#is', '', $str);

	return $str;

}

// bersihkan teks dr spasi dobel

function clean_spaces($str)
{
	$str = (string) $str;
	$str = (string) preg_replace('/\s+/', ' ', $str);
	$str = (string) trim($str);

	return $str;

}

// bersihkan string2 dlm array

function clean_array($array, $max_length = 100)
{
	$array = (array) $array;
	$hasil = array();

	foreach ($array as $str):
		$str = clean($str);

		if (strlen($str) == 0)
			continue;

		$hasil[] = substr($str, 0, $max_length);

	endforeach;

	return $hasil;

}

// detek client agent

function client_agent()
{
	$ci = & get_instance();
	$ci->load->library('user_agent');

	if ($ci->agent->is_browser())
		return 'browser';

	if ($ci->agent->is_mobile())
		return 'mobile';

	if ($ci->agent->is_robot())
		return 'robot';

	return 'other';

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

// ngambil data dr row ++ prefix+sufix

function data_cell($cfg, $row = array())
{
	$tdata = data_eval($cfg, $row);
	$cfg = (array) $cfg;

	if (count($cfg) == 1)
		return $tdata;

	if (isset($cfg['prefix']))
		$tdata = $cfg['prefix'] . $tdata;

	if (!isset($cfg['suffix']))
		return $tdata;

	if (!is_array($cfg['suffix']))
		return $tdata . $cfg['suffix'];

	foreach ($cfg['suffix'] as $sfix)
		$tdata .= data_cell($sfix, $row);

	return $tdata;

}

// bersihkan array dr key integer, valuenya jg dihapus

function data_cfgclean(&$cfg)
{
	foreach (array_keys($cfg) as $i)
		if (!is_int($i))
			unset($cfg[$i]);

}

// ambil data sederhana dr row

function data_eval($cfg, $row = array())
{

	$row = (array) $row;

	if (!is_array($cfg))
		return array_key_exists($cfg, $row) ? $row[$cfg] : $cfg;

	if (!isset($cfg[0]))
		return NULL; // exception

	data_cfgclean($cfg);

	if ($cfg[0] && array_key_exists($cfg[0], $row))
		$cfg[0] = (string) $row[$cfg[0]]; // ambil data row

	if (!isset($cfg[1]))
		return $cfg[0];

	if (is_array($cfg[1]))
		return (array_key_exists($cfg[0], $cfg[1])) ? $cfg[1][$cfg[0]] : $cfg[0]; // dr array

	if (is_string($cfg[1]) && !function_exists($cfg[1]))
		return $cfg[0];

	if (is_null($cfg[0]))
		unset($cfg[0]);

	else if ($cfg[0] === FALSE)
		$cfg[0] = $row; // masukan seluruh row ke parameter

	$fungsi = $cfg[1];
	unset($cfg[1]);

	if (array_key_exists(-1, $cfg)):
		ksort($cfg);
		$cfg = array_values($cfg);
	endif;

	return call_user_func_array($fungsi, $cfg);

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

// perbaikan kemungkinan salah format datetime

function datefix($text, $format = 'Y-m-d H:i:s')
{
	if (!$text OR $text == '0000-00-00' OR $text == '0000-00-00 00:00' OR $text == '0000-00-00 00:00:00')
		return NULL;

	$dto = date_create($text);

	if (!$dto)
		return NULL;

	$dtm = $dto->format($format);

	if (!$dtm OR $dtm == '0000-00-00' OR $dtm == '0000-00-00 00:00' OR $dtm == '0000-00-00 00:00:00')
		return NULL;

	return $dtm;

}

// delete file

function delete($full_path)
{
	if (!$full_path)
		return;

	if (file_exists($full_path)):
		try
		{
			@chmod($full_path, 0775);
			@unlink($full_path);
		}
		catch (Exception $e)
		{
			return;
		}
	endif;

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

//cek file extension

function file_ofis($data, $ext_node = array())
{

	if (is_array($data) && !empty($ext_node)):
		$ext_node = (array) $ext_node;
		$data = array_node($data, $ext_node);
	endif;

	if (!$data)
		return FALSE;

	$data = (string) $data;
	$data = (string) trim($data, ' .');

	return in_array($data, array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'odt', 'ods', 'odp'));

}

// extrak title dr alamat tertentu

function get_title($url)
{
	$url = str_replace('http://', '', $url);
	$url = str_replace('https://', '', $url);
	$url = 'http://textance.herokuapp.com/title/' . $url;
	$title = (string) @file_get_contents($url);

	if (!$title)
		return NULL;

	if (strpos($title, '<') !== FALSE)
		return NULL;

	return $title;

}

// menampilkan foto

function img_foto($full_path, $attr = array())
{
	//$full_path = path_relative($full_path);
	$root_full_path =APP_ROOT.$full_path;
	$attr['src'] = base_url('content/no-photo.jpg');

	if (!empty($full_path) && file_exists($root_full_path))
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

// konversi integer jika munkin

function intif($str)
{
	return (is_numeric($str) && strlen($str) <= 10) ? (int) $str : $str;

}

// buat tag li

function li($attr = '', $inner = '')
{
	return tag('li', $attr, $inner) . NL;

}

// link script

function link_js($href)
{
	/*return '<script type="text/javascript" src="' . base_url($href) . '"></script>' . NL;*/
    return '<script type="text/javascript" src="http://' . URL_MASTER.$href . '"></script>' . NL;

}

// buat kode  hash pendek

function md6($param, $key = APP_NAME)
{
	return md5($param . $key);

}

function password_generator($user_id)
{
	$ci = & get_instance();
	$kunci_password = $ci->md->row_col('value', "select `value` from app_config where id = 4");

	$user_id = $user_id;
	$hash = md5($user_id . $kunci_password);

	return substr($hash, 0, 6);

}

// buat tag p

function p($attr = '', $inner = '')
{
	return tag('p', $attr, $inner);

}

// konversi path folder ke web path

function path_relative($path)
{
	return ($path) ? str_replace(APP_ROOT, '', $path) : NULL;

}

// menyiapkan direktori u. upload

function prep_dir($path)
{
	if (file_exists($path))
		return TRUE;

	try
	{
		mkdir($path, 0775, TRUE);
	}
	catch (Exception $e)
	{
		return $e->getMessage();
	}

	return TRUE;

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

// kirim email

function send_mail($data)
{
	$ci = & get_instance();
	$ci->load->library('email');
	$ci->email->from(MAILER_ADDRESS, MAILER_NAME);
	$ci->email->to($data['to']);
	$ci->email->subject($data['subject']);
	$ci->email->message($data['message']);

	if ($ci->email->send())
		return 'sent';
	else
		return $ci->email->print_debugger();

}

// buat tag span//

function span($attr = '', $inner = '')
{
	return tag('span', $attr, $inner);

}

// hapus tag tertentu
// http://altafphp.blogspot.com/2011/12/remove-specific-tag-from-php-string.html

function strip_single($tag, $string)
{
	$string = preg_replace('/<' . $tag . '[^>]*>/i', '', $string);
	$string = preg_replace('/<\/' . $tag . '>/i', '', $string);
	return $string;

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

// convert datetime ke jam

function waktu($tanggal)
{
	$tanggal = (string) $tanggal;

	if (!$tanggal OR $tanggal == '0000-00-00' OR $tanggal == '0000-00-00 00:00:00')
		return NULL;

	//$a_hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
	//$a_bulan = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des');

	$date = date_create($tanggal);

	/*$i_bln = date_format($date, 'n');
	$i_hr = date_format($date, 'w');
	$hari = $a_hari[$i_hr];
	$bulan = $a_bulan[$i_bln];
	$tgl = date_format($date, 'j');
	$tahun = date_format($date, 'Y');*/
	$waktu = date_format($date, 'H:i');

	return "{$waktu}";

}

// convert date ke string

function tgl($tanggal, $rinkas_tahun = FALSE, $tipe = 'normal')
{
	$tanggal = (string) $tanggal;

	if (!$tanggal OR $tanggal == '0000-00-00' OR $tanggal == '0000-00-00 00:00:00')
		return NULL;

	$a_hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
	$a_bulan = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des');
	
	$a_bulan2 = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

	$dt = date_create($tanggal);

	if (!$dt)
		return NULL;

	$i_hr = (int) date_format($dt, 'w');
	$i_bln = (int) date_format($dt, 'n');

	$hari = $a_hari[$i_hr];
	$bulan = $a_bulan[$i_bln];
	$bulan2 = $a_bulan2[$i_bln];

	$tgl = date_format($dt, 'j');
	$tahun = date_format($dt, 'Y');

	if ($rinkas_tahun && $tahun == date('Y'))
		$tahun = '';

	if($tipe == 'normal')
		return trim("{$hari}, {$tgl} {$bulan} {$tahun}");
	elseif($tipe == 'slash')
		return trim("{$hari} / {$tgl} {$bulan2} {$tahun}");

}

// trim double space

function trimin($str)
{

	if (empty($str))
		return '';
	else
		return clean($str);

	// fungsi ini tak digunakan lagi

	$str = strip_tags($str);
	$str = clean($str);
	$arr = explode(' ', $str);

	foreach (array_keys($arr) as $i)
		$arr[$i] = trim($arr[$i], ' .…');

	$arr = array_filter($arr);

	return implode(' ', $arr);

}

// lingkup user role

function user_role()
{
	$ci = & get_instance();
	$roles = (array) func_get_args();
	$current = $ci->d['user']['role'];

	if (!$roles)
		return TRUE;

	if (in_array('#login', $roles))
		return (bool) (isset($ci->d['user']['id']) && $ci->d['user']['id'] > 0);

	if (!$current)
		$current = 'anonim';

	return in_array($current, $roles);

}

// konversi path folder ke web path

function webpath($path)
{
	return ($path) ? str_replace(APP_ROOT, APP_ADDRESS, $path) : NULL;

}

// khusus aplikasi

function belajar($pelajaran_id)
{
	$siswa = user_role('siswa');
	$pelajaran_id = intif($pelajaran_id);

	if (!$siswa)
		return FALSE;

	$pelajaran_list = cfgu('pelajaran_list');

	if (empty($pelajaran_list) OR ! is_array($pelajaran_list))
		return FALSE;

	return in_array($pelajaran_id, $pelajaran_list);

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

function cosmo_js()
{
	return '<!-- Le javascript ====== Placed at the end of the document so the pages load faster -->' . NL
		. link_js('assets/jquery-ui_1.10.3/js/jquery-1.9.1.js')
		//. link_js('assets/bootswatch_cosmo/jquery.min.js')
		. link_js('assets/bootswatch_cosmo/jquery.smooth-scroll.min.js')
		. link_js('assets/bootswatch_cosmo/bootstrap.min.js')
		. link_js('assets/bootswatch_cosmo/bootswatch.js')
		. link_js('js/common.js');

}

function formnil_angka($nilai)
{
	return $nilai;

	if (!is_numeric($nilai))
		return $nilai;

	return round($nilai);

}

function formnil_huruf($nilai, $round = TRUE)
{
	if (!is_numeric($nilai))
		return '-';

	if ($nilai >= 100)
		return 'Seratus';

	if ($nilai <= 0)
		return 'Nol';

	if ($round)
		$nilai = round($nilai);

	$nilai = (string) $nilai;
	$huruf = array(
		'Nol', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan',
		','	 => 'Koma', '.'	 => 'Koma',
	);
	$array = str_split($nilai);

	foreach ($array as $i => $n)
		$array[$i] = $huruf[$n];

	return implode(' ', $array);

}

function formnil_predikat($n)
{
	if (!is_numeric($n))
		return $n;

	if ($n >= 86)
		return 'A';

	if ($n >= 71)
		return 'B';

	if ($n >= 56)
		return 'C';

	if ($n >= 41)
		return 'D';

	return 'E';

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

function mengajar($pelajaran_id)
{
	$sdm = user_role('sdm');
	$pelajaran_id = intif($pelajaran_id);

	if (!$sdm)
		return FALSE;

	$mengajar_list = cfgu('mengajar_list');

	if (empty($mengajar_list) OR ! is_array($mengajar_list))
		return FALSE;

	return in_array($pelajaran_id, $mengajar_list);

}

function nama_alias($nama)
{
	$nm_array = explode(' ', $nama);

	if (!$nm_array)
		return '';

	$alias = $nm_array[0];

	return substr($alias, 0, 32);

}

function walikelas($kelas_id)
{
	$sdm = user_role('sdm');
	$kelas_id = intif($kelas_id);

	if (!$sdm)
		return FALSE;

	$walikelas = cfgu('walikelas');

	if (empty($walikelas) OR ! is_array($walikelas))
		return FALSE;

	return in_array($kelas_id, $walikelas);

}

/*
 * konversi datetime ke string tgl indonesia & jam
 */

function tanggal($tanggal, $month_short = FALSE, $show_hari = FALSE, $show_jam = FALSE)
{
	$tanggal = (string) $tanggal;

	if (!$tanggal OR $tanggal == '0000-00-00' OR $tanggal == '0000-00-00 00:00:00')
	{
		return NULL;
	}

	$a_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
	$a_bulan = array("", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des");
	$l_bulan = array(
		"",
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mei",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember",
	);

	$date = date_create($tanggal);

	$i_bln = date_format($date, 'n');
	$bulan = ($month_short) ? $a_bulan[$i_bln] : $l_bulan[$i_bln];
	$tgl = date_format($date, 'j');
	$tahun = date_format($date, 'Y');
	$teks = "{$tgl} {$bulan} {$tahun}";

	if ($show_hari)
	{
		$i_hr = date_format($date, 'w');
		$hari = $a_hari[$i_hr];
		$teks = "{$hari}, {$teks}";
	}

	if ($show_jam)
	{
		$waktu = date_format($date, 'H:i');
		$teks .= " jam {$waktu}";
	}

	return $teks;

}

function JamToDetik($str_time){
	
	$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

	sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

	$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
	
	return $time_seconds;
}
