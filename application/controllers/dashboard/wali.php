<?php

class Wali extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
			'controller' => array(
				'user' => 'wali',
			)
		));
	}

	public function index() {
		exit('dash wali');
		$this->_set('dashboard/wali/index');

		$this->_view();
	}

}
