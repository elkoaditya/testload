<?php

class M_log_signin_daily extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	// operasi system

	function login() {

		$user = $this->session->userdata('user');
		$date = $this->ci->d['dto']->format('Y-m-d');

		if (!is_array($user) OR $user['id'] == 0)
			return;

		if ($this->agent->is_browser())
			$agent = 'browser';
		elseif ($this->agent->is_mobile())
			$agent = 'mobile';
		else
			$agent = 'other';

		$robot = (bool) $this->agent->is_robot();

		if ($robot):
			$sql_upd = "update log_signin_daily set {$agent} = {$agent} + 1, robot_detect = 1 where user_id = {$user['id']} and tgl = '{$date}'";
			$sql_ins = "insert into log_signin_daily(user_id, tgl, robot_detect, {$agent}) values({$user['id']}, '{$date}', 1, 1)";
		else:
			$sql_upd = "update log_signin_daily set {$agent} = {$agent} + 1 where user_id = {$user['id']} and tgl = '{$date}'";
			$sql_ins = "insert into log_signin_daily(user_id, tgl, {$agent}) values({$user['id']}, '{$date}', 1)";
		endif;

		$this->db->query($sql_upd);

		$count = $this->db->affected_rows();

		if (!$count)
			$this->db->query($sql_ins);
	}

}

