<?php

class Admin extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
			'controller' => array(
				'user' => 'admin',
			)
		));
	}

	public function index() {
		$this->_set('dashboard/admin');
		$this->_view();
	}

}
