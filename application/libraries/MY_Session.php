<?php

class MY_Session extends CI_Session {

	var $new = FALSE;

	public function __construct() {
		parent::__construct();
	}

	function clean() {
		$session = (array) $this->all_userdata();

		foreach ($session as $key => $sesi):
			if (!is_array($sesi) OR !isset($sesi['expire']))
				continue;

			if ($sesi['expire'] && $sesi['expire'] < $this->CI->d['time']):
				$this->unset_userdata($key);

				if (is_array($sesi['upload']) && isset($sesi['upload']['full_path']))
					delete($sesi['upload']['full_path']);

			endif;
		endforeach;
	}

	function data($key, $new_value = NULL) {
		if ($new_value === NULL)
			return $this->userdata($key);
		else
			return $this->set_userdata($key, $new_value);
	}

	function isnew() {
		return $this->new;
	}

	function renew() {
		$main = array('session_id', 'ip_address', 'user_agent', 'last_activity');
		$session = (array) $this->all_userdata();

		foreach (array_keys($session) as $key)
			if (!in_array($key, $main))
				$this->unset_userdata($key);

		$this->sess_update();
		$this->user_anonim();
	}

	function sess_create() {
		parent::sess_create();
		$this->new = TRUE;
		$this->user_anonim();
	}

	function sess_update() {
		if (!$this->CI->input->is_ajax_request())
			parent::sess_update();
	}

	function unset_userdata($newdata = array()) {

		if (!is_array($newdata))
			$newdata = array($newdata => '');

		return parent::unset_userdata($newdata);
	}

	function user_anonim() {
		$this->CI->d['user'] = array(
				'id' => 0,
				'role' => 'anonim',
				'username' => 'anonim',
				'alias' => 'anonim',
				'nama' => 'anonim',
		);
		$this->set_userdata('user', $this->CI->d['user']);
	}

}

