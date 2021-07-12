<?php

class MY_Controller extends CI_Controller
{

	var $cfg;

	var $d = array(
		'uri'		 => '',
		'appconfig'	 => array(),
		'alert'		 => array(),
		'request'	 => array(),
		'sql'		 => array(),
		'error'		 => FALSE,
		'semaktif'	 => array(
			'id'				 => 0,
			'no'				 => 0,
			'nama'				 => 'masa jeda akademik',
			'ta_id'				 => 0,
			'ta_nama'			 => '',
			'akhir'				 => NULL,
			'term'				 => 'minimester',
			'status'			 => 'aktif',
			'batas_entry_nilai'	 => NULL,
			'kenaikan_kelas'	 => FALSE,
		),
	);

	//---------------
	// fungsi utama / system needs

	public function __construct($cfg = array())
	{
		parent::__construct();

		$this->cfg = $cfg;
		$this->d['dto'] = new DateTime();
		$this->d['time'] = $this->d['dto']->getTimestamp();
		$this->d['datetime'] = $this->d['dto']->format('Y-m-d H:i:s');
		$this->d['user'] = $this->session->userdata('user');
		$this->d['alert'] = (array) $this->session->flashdata('alert');
		$this->d['post_request'] = ($this->input->server('REQUEST_METHOD') == 'POST');

		if (!isset($this->d['alert']['error']))
			$this->d['alert']['error'] = array();

		if (!isset($this->d['alert']['info']))
			$this->d['alert']['info'] = array();

		if (!isset($this->d['alert']['success']))
			$this->d['alert']['success'] = array();

		// load config controller

		if (isset($cfg['controller']))
			$this->_initcfg($cfg['controller']);

		// hapus sesi form expired

		$this->session->clean();

		// set semester aktif

		$this->_semaktif();

		// pastikan sesi user

		if (!$this->d['user'])
			$this->session->user_anonim();

		// load seting sistem

		$query = $this->db->get('app_config');

		if ($query->num_rows() > 0):

			foreach ($query->result_array() as $row):
				if ($row['type'] == 'integer')
					$row['value'] = as_int($row['value']);
				else if ($row['type'] == 'float')
					$row['value'] = (float) $row['value'];
				else if ($row['type'] == 'array')
					$row['value'] = (array) json_decode($row['value'], TRUE);

				$this->d['appconfig'][$row['key']] = $row['value'];

			endforeach;

			if (isset($this->d['appconfig']['autoload.controller']))
				$this->_initcfg($this->d['appconfig']['autoload.controller']);

		endif;

	}

	// dumping $this->d

	public function _dump($var = NULL)
	{
		echo "<pre>";

		if ($var !== NULL)
			echo "<h2>Var :</h2><p>{$var}</p>";

		echo " <h2>Data :</h2><p>" . print_r($this->d, TRUE) . "</p>";
		echo " <h2>Session :</h2><p>" . print_r($this->session->all_userdata(), TRUE) . "</p>";
		echo '</pre>';
		exit();

	}

	// inisiasi config

	public function _initcfg($cfg)
	{
		if (isset($cfg['user']))
			call_user_func_array(array($this, '_user'), (array) $cfg['user']);

		if (isset($cfg['uri']))
			$this->d['uri'] = $cfg['uri'];

		if (isset($cfg['data']) && is_array($cfg['data']))
			foreach (array_keys($cfg['data']) as $i)
				$this->d[$i] = $cfg['data'][$i];

		foreach (array('library', 'helper') as $component):

			if (!isset($cfg[$component]))
				continue;

			$cfg[$component] = (array) $cfg[$component];

			foreach ($cfg[$component] as $obj)
				if ($obj)
					$this->load->$component($obj);

		endforeach;

		if (isset($cfg['model'])):

			$cfg['model'] = (array) $cfg['model'];

			foreach ($cfg['model'] as $key => $obj):

				if (!$obj)
					continue;

				if (is_string($key))
					$this->load->model($obj, $key);
				else
					$this->load->model($obj);

			endforeach;

		endif;

		if (isset($cfg['request']))
			$this->_request($cfg['request']);

	}

	// cekpoint ajax, bila error, keluar

	public function _json_error_escape($redir = FALSE)
	{
		if ($this->d['error']):

			if ($redir)
				$this->d['redir'] = $redir;

			$this->_json_output();

		endif;

	}

	// json data output

	public function _json_output()
	{
		exit(json_encode($this->d));

	}

	// output PDF

	public function _pdf($filename = 'download', $file = '')
	{
		$download = (bool) $this->input->get_post('download');
		$mode = ($download) ? 'D' : 'I';
		$html = $this->_view($file, TRUE);

		$this->load->library('mpdf');
		$this->mpdf->setAutoTopMargin = TRUE;
		$this->mpdf->setAutoBottomMargin = TRUE;
		$this->mpdf->showWatermarkText = TRUE;
		$this->mpdf->showWatermarkImage = TRUE;
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output("{$filename}.pdf", $mode);

	}

	// default page redirect

	public function _redir($req = FALSE)
	{
		$qs = (array) $this->input->get();
		$qs['id'] = (string) $this->input->get_post('id');
		$redir = (string) $this->input->get_post('redir');
		$curi = $this->uri->uri_string();
		$user = (array) $this->session->userdata('user');
		$signed = (isset($user['id']) && $user['id'] > 0);

		if (isset($qs['redir']))
			unset($qs['redir']);

		if ($req && $redir != $curi):
			$uri = $redir . array2qs($qs);

		elseif (!$signed):
			$qs['redir'] = $curi;
			$uri = 'login' . array2qs($qs);

		else:
			$uri = "data/profil/{$user['role']}/id/{$user['id']}?ringkas=ya";

		endif;

		return redir($uri);

	}

	// olah request

	public function _request($cfg)
	{
		foreach ($cfg as $idx => $field):
			if (is_numeric($idx)):
				$this->d['request'][$field] = $this->input->get_post($field);

			else:
				$this->d['request'][$idx] = $this->input->get_post($idx);
				$field = (array) explode('|', $field);

				foreach ($field as $fnc)
					$this->d['request'][$idx] = call_user_func($fnc, $this->d['request'][$idx]);

			endif;
		endforeach;

	}

	// load model & get row

	public function _rowset($model, $id, $redir = '', $dsnode = 'row')
	{

		$this->load->model($model);

		if (!is_array($id))
			$row = $this->$model->rowset($id);
		else
			$row = call_user_func_array(array($this->$model, 'rowset'), $id);

		if (!$row)
			alert_error("Data yang Anda maksud tidak ditemukan.");

		if ($this->d['error'] && $redir != '')
			return redir($redir);

		if (!$dsnode)
			return $row;
		else
			$this->d[$dsnode] = $row;

	}
	public function _rowset2($model, $id, $redir = '', $dsnode = 'row')
	{

		$this->load->model($model);

		if (!is_array($id))
			$row = $this->$model->rowset2($id);
		else
			$row = call_user_func_array(array($this->$model, 'rowset2'), $id);

		if (!$row)
			alert_error("Data yang Anda maksud tidak ditemukan.");

		if ($this->d['error'] && $redir != '')
			return redir($redir);

		if (!$dsnode)
			return $row;
		else
			$this->d[$dsnode] = $row;

	}

	// load semester aktif

	public function _semaktif()
	{
		$query = array(
			'select'	 => array(
				'prd_semester.*',
				'ta_nama' => 'prd_ta.nama',
			),
			'from'		 => 'prd_semester',
			'join'		 => array(
				array('prd_ta', 'prd_semester.ta_id = prd_ta.id', 'inner'),
			),
			'order_by'	 => 'id desc',
		);
		$sems = $this->md->query($query)->row();

		if (is_array($sems) && $sems['status'] == 'aktif'):
			$this->d['semaktif']['id'] = (int) $sems['id'];
			$this->d['semaktif']['no'] = (int) $sems['no'];
			$this->d['semaktif']['nama'] = $sems['nama'];
			$this->d['semaktif']['ta_id'] = $sems['ta_id'];
			$this->d['semaktif']['ta_nama'] = $sems['ta_nama'];
			$this->d['semaktif']['akhir'] = $sems['akhir'];
			$this->d['semaktif']['term'] = $sems['term'];
			$this->d['semaktif']['status'] = $sems['status'];
			$this->d['semaktif']['batas_entry_nilai'] = $sems['batas_entry_nilai'];
			$this->d['semaktif']['kenaikan_kelas'] = $sems['kenaikan_kelas'];

		else:
			$this->db->from('prd_ta')->order_by('id desc');

			$ta = $this->md->row();

			if ($ta):
				$this->d['semaktif']['ta_id'] = $ta['id'];
				$this->d['semaktif']['ta_nama'] = $ta['nama'];
			endif;

		endif;

	}

	// set uri/action yg dijalankan & load seting

	public function _set($uri)
	{
		$this->d['uri'] = $uri;
		$apconf = "autoload.{$uri}";

		if (isset($this->cfg[$uri]))
			$this->_initcfg($this->cfg[$uri]);

		if (isset($this->d['appconfig'][$apconf]))
			$this->_initcfg($this->d['appconfig'][$apconf]);

	}

	// daftar user akses
	// tanpa login = anonim

	public function _user()
	{
		$roles = (array) func_get_args();
		$grant = call_user_func_array('user_role', $roles);

		if (!$roles)
			return;

		if (!$grant):
			$msg = (in_array('anonim', $roles)) ? 'Anda mengakses ke halaman yang salah.' : 'Silahkan login untuk melanjutkan';
			alert_error($msg);
			$this->_redir();
		endif;

	}

	// tampilkan view

	public function _view($file = '', $return = FALSE)
	{
		$path = trim(THEME . "/{$this->d['uri']}/{$file}", ' /');
		return $this->load->view($path, $this->d, $return);

	}

}
