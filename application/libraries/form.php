<?php

class Form
{

	var $ci;

	var $sesi;

	var $expire_time = 28800;

	var $rule = array();

	public function __construct()
	{
		$this->ci = & get_instance();
		$this->ci->load->library('form_validation');

		if (!isset($this->ci->d['form']))
			$this->ci->d['form'] = $this->session_default(TRUE);

		$this->sesi = & $this->ci->d['form'];

	}

	public function get($form_name = FALSE, $delete = TRUE)
	{
		$referer = $this->ci->input->get_request_header('Referer', TRUE);
		$token = $this->ci->input->post('token');
		$this->sesi = $this->ci->session->userdata($token);
		$form_name = (!$form_name) ? $this->ci->d['uri'] : $form_name;

		if (!$referer OR ! strstr($referer, base_url()))
			return alert_error('Form invalid');

		if (!$token)
			return alert_error('sesi form tidak dikenal');

		if (!$this->sesi)
			return alert_error('sesi form melebihi batas waktu');

		if ($this->sesi['form'] != $form_name)
			return alert_error('form invalid');

		if ($delete)
			$this->ci->session->unset_userdata($token);

	}

	public function init($model = '', $redirect = '', $dsnode = 'row')
	{

		if ($this->ci->d['post_request'])
			$this->get();

		if (!$this->ci->d['post_request'] OR ! $this->sesi)
			$this->sesi = $this->session_default(TRUE);

		if ($model != '' && $this->sesi['id']):
			$row = $this->ci->_rowset($model, $this->sesi['id'], $redirect, FALSE);

			if ($row)
				$this->ci->d[$dsnode] = $row;

		endif;

	}

	public function remove()
	{
		$this->ci->session->unset_userdata($this->sesi['token']);

	}

	public function rule()
	{
		$args = (array) func_get_args();
		$nums = func_num_args();

		if ($nums == 0)
			$cfg = cfgc('validation');
		else if (is_array($args[0]))
			$cfg = $args[0];
		else
			$cfg = call_user_func_array('cfgc', $args);

		if (is_array($cfg))
			$this->rule = array_merge($this->rule, $cfg);

	}

	public function ruleset($row, $cfg = 'validationset')
	{

		if (!is_array($cfg))
			$cfg = (array) cfgc($cfg);

		foreach ($cfg as $key => $subcfg):

			if (is_integer($key) OR ! isset($row[$key])):
				$this->rule($subcfg);
				continue;
			endif;

			$input = $this->ci->input->post($key);
			$differ = is_string($input) ? strcasecmp($input, $row[$key]) : ($input != $row[$key]);

			if ($input && $differ)
				$this->rule($subcfg);

		endforeach;

	}

	public function session_clean()
	{
		$time_min = $this->ci->d['time'] - $this->expire_time;

		$this->ci->db->where('time <', $time_min);
		$this->ci->db->delete('app_form');

	}

	public function session_default($get_input_id = FALSE)
	{
		return array(
			'id'	 => (($get_input_id) ? $this->ci->input->get_post('id') : 0),
			'form'	 => $this->ci->d['uri'],
			'upload' => NULL,
			'expire' => ($this->ci->d['time'] + $this->expire_time),
			'token'	 => '',
		);

	}

	public function session_delete($table, $ids)
	{
		$hash = array_hash($table, $ids);
		$time_min = $this->ci->d['time'] - $this->expire_time;

		$this->ci->db->trans_start();
		$this->ci->db->where('id', $hash)->or_where('time <', $time_min)->delete('app_form');
		$this->ci->db->trans_commit();

	}

	public function session_get($table, $ids)
	{
		$hash = array_hash($table, $ids);
		$time_min = $this->ci->d['time'] - $this->expire_time;
		$query = array(
			'select' => array(
				'form.*',
				'user_alias' => 'user.alias',
				'user_nama'	 => 'user.nama',
			),
			'from'	 => 'app_form form',
			'join'	 => array(
				array('data_user user', 'form.user_id = user.id', '')
			),
			'where'	 => array(
				'form.id'		 => $hash,
				'form.time >'	 => $time_min,
			),
			'limit'	 => 1,
		);

		$row = $this->ci->md->query($query)->row();

		if (!$row)
			return FALSE;

		$row['xdat'] = json_decode($row['xdat'], TRUE);

		return $row;

	}

	public function session_set($table, $ids, $xdat = array())
	{
		$data['id'] = array_hash($table, $ids);
		$data['xdat'] = json_encode($xdat);
		$data['user_id'] = $this->ci->user['id'];
		$data['time'] = $this->ci->d['time'];

		$this->ci->db->trans_start();
		$this->ci->db->insert('app_form', $data);

		return $this->ci->md->trans_done();

	}

	public function session_update($id, $xdat = FALSE)
	{
		if (is_array($id))
			$id = call_user_func_array('array_hash', $id);

		$data['time'] = $this->ci->d['time'];

		if ($xdat)
			$data['xdat'] = json_encode($xdat);

		$this->ci->db->trans_start();
		$this->ci->db->update('app_form', $data, array('id' => $id));

		return $this->ci->md->trans_done();

	}

	public function set()
	{
		$this->sesi['token'] = md5($this->sesi['form'] . $this->sesi['id'] . $this->ci->d['time']);
		$this->ci->session->set_userdata($this->sesi['token'], $this->sesi);

	}

	public function validate()
	{
		$this->ci->form_validation->set_rules($this->rule);
		$val = $this->ci->form_validation->run();

		if (!$val)
			alert_error(validation_errors());

		$this->rule = array();

		return $val;

	}

}
