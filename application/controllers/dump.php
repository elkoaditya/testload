<?php

class Dump extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		//exit('ok');
		$this->sesi();
	}

	public function extension() {
		echo '<pre>';
		print_r(get_loaded_extensions());
		echo '</pre>';
	}

	public function facebook() {
		echo '<pre>';
		if (isset($this->fb))
			print_r($this->fb->getProfile());
		else
			echo 'Facebook SDK not set';
		echo '</pre>';
	}

	public function sesi() {
		echo '<pre>'
		. print_r($this->session->all_userdata(), TRUE)
		. crypto('adman') . '<br/>'
		. crypto('admin') . '<br/>'
		. crypto('admun') . '<br/>'
		. crypto('admen') . '<br/>'
		. crypto('admon') . '<br/>'
		. '</pre>';
		exit();
	}

}

