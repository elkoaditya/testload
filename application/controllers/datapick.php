<?php

// project  :
// filename : app/controller/datapick

class Datapick extends MY_Controller {

	public function __construct() {
		parent::__construct();

		if ($this->user == FALSE)
			exit('[]');

		// sample config

		$cfg = array(
				'term-numeric' => 'id', // pencarian numeric
				'term-string' => 'name', // pencarian string
				'sql_shape' => array(
						'select' => array(
								'value' => 'table.id', // value u/ autocomplete, wajib
								'label' => 'table.name', // label u/ autocomplete, wajib
						),
				),
		);
	}

	public function _get($cfg) {
		$term = clean($this->input->get('term'));
		$default = array(
				'term-numeric' => 'id',
				'term-string' => 'name',
				'sql_shape' => array(
						'select' => array(
								'value' => 'id',
								'label' => 'name',
						),
						'limit' => 20,
				),
		);

		set_default($cfg, $default);
		$this->md->shape($cfg['sql_shape']);

		if (is_numeric($term) && $term > 0)
			$this->db->where($cfg['term-numeric'], (int) $term);
		else
			$this->md->like($term, $cfg['term-string']);

		$query = $this->db->get();

		echo json_encode($query->result_array());
	}

	public function sample() {
		$cfg = array(
				'term-numeric' => 'user.id',
				'term-string' => array('user.nama'),
				'sql_shape' => array(
						'select' => array(
								'value' => 'user.id',
								'label' => 'user.nama',
								'user.nomor',
								'user.gender',
								'user.avatar',
						),
						'from' => 'user',
						'where' => array('user.tipe' => "guru"),
						'order_by' => 'user.nama',
						'limit' => 20,
				),
		);
		return $this->_get($cfg);
	}

}

