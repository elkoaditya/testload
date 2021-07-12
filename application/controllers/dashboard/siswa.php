<?php

class Siswa extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
			'controller' => array(
				'user' => 'siswa',
			)
		));
	}

	public function index() {
		$this->_set('dashboard/siswa');
		$this->_view();
	}

}
