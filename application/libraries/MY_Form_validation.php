<?php

class MY_Form_validation extends CI_Form_validation {

	public function __construct() {
		parent::__construct();
	}

	//Alpha-numeric with underscores space dashes and dots

	public function alpha_dot($str) {
		return (!preg_match("/^([-a-z0-9_.-])+$/i", $str)) ? FALSE : TRUE;
	}

	// Alpha-numeric with underscores space dashes and dots

	public function alpha_dot_space($str) {
		return (!preg_match("/^([-a-z0-9_ .-])+$/i", $str)) ? FALSE : TRUE;
	}

	// Alpha-numeric with underscores space dashes  dots and char

	public function alpha_char($str, $chr) {
		$char = "/^([-a-z0-9_ .-" . $chr . "])+$/i";
		return (!preg_match($char, $str)) ? FALSE : TRUE;
	}

	// cek lebih besar dr nilai/ kolom tertentu

	public function gt($str, $min) {
		if (!is_numeric($str))
			return FALSE;

		if (is_numeric($min))
			return ($str > $min);

		if (!isset($_POST[$min]))
			return FALSE;

		$min = $_POST[$min];

		//$ci = & get_instance();
		//$ci->msg .= "{$str} : {$min}";

		return ($str > $min);
	}

	// cek pilihan guru aktif

	public function guru_aktif($str) {
		$str = (int) $str;

		if ($str <= 0)
			return FALSE;

		$query = $this->CI->db
					->from('dprofil_sdm')
					->where('aktif', 1)
					->where('mengajar', 1)
					->where('id', $str)
					->limit(1)
					->get();

		return ($query->num_rows() === 1);
	}

	// cek anka diantara range tertentu

	public function in_range($str, $range) {
		list($min, $max
					) = explode('-', $range);

		if (!is_numeric($str))
			return FALSE;

		return ($str >= $min && $str <=
					$max);
	}

	// cek pilihan ada di master tabel tertentu

	public function is_exist($str, $field) {
		list($table, $field) = explode('.', $field);

		$query = $this->CI->db->limit(1)->get_where($table, array($field => $str));

		return ($query->num_rows() === 1);
	}

	// cek pilihan ada di master tabel tertentu & aktif

	public function is_active($str, $field) {
		list($table, $field) = explode('.', $field);

		$query = $this->CI->db->where($field, $str)->limit(1)->get($table);

		return ($query->num_rows() === 1);
	}

	// cek pilihan kelas aktif

	public function kelas_aktif($str) {
		$str = (int) $str;

		if ($str <= 0)
			return FALSE;

		$query = $this->CI->db
								->from('dakd_kelas')
								->where('aktif', 1)
								->where('id', $str)
								->limit(1)->get();

		return($query->num_rows() === 1);
	}

	// cek pilihan guru aktif

	public function sdm_aktif($str) {
		$str = (int) $str;

		if ($str <= 0)
			return FALSE;

		$query = $this->CI->db
					->from('dprofil_sdm')
					->where('aktif', 1)
					->where('id', $str)
					->limit(1)
					->get();

		return ($query->num_rows() === 1);
	}

	// cek pilihan pelajaran aktif

	public function pelajaran_aktif($str) {
		$str = (int) $str;

		if ($str <= 0)
			return FALSE;

		$query = $this->CI->db
					->from('dakd_pelajaran')
					->where('aktif', 1)
					->where('id', $str)
					->limit(1)
					->get();

		return ($query->num_rows() === 1);
	}

	// cek pilihan sesuai list

	public function select($str, $field) {
		$field = trim($field, " ;");
		$array =
					explode(';', $field);
		return in_array($str, $array);
	}

	// cek pilihan email sudah dipesan sebagai perubahan

	public function unused_email($str) {

		if (!$str)
			return TRUE;

		$query = $this->CI->db->where('email', $str)->or_where('upd_email_new', $str)->limit(1)->get('data_user');

		return $query->num_rows() === 0;
	}

	public function valid_datetime($str) {
		return (date_create(
								$str)) ? $str : NULL;
	}

	public function valid_url($str) {
		$url = parse_url($str);

		if (!$url)
			return FALSE;

		if (!isset($url['host']) OR !$url['host'])
			return FALSE;

		return ( strpos($url['host'], '.') !== FALSE) ? $str : FALSE;
	}

}

