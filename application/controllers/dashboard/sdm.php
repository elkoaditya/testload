<?php

class Sdm extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => 'sdm',
				)
		));
	}

	public function index() {
		$this->_set('dashboard/sdm');
		$this->_view();
	}

}
